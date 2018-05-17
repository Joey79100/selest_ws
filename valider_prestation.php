<?php
	
	/*
	* Crée une conversation, ajoute des participants, et envoie un message
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// stopper l'exécution du script si l'utilisateur n'est pas connecté
	check_connection(RIGHTS_WRITER);
	
	
	// vérification de la présence des données
	if (
			isset($_POST["pre_id"])
		AND isset($_POST["adh_ids"])
	) {

		// paramètres obligatoires
		$pre_id = $_POST["pre_id"];
		$adh_ids_str = $_POST['adh_ids'];

		$uti_adh_id = $_SESSION['selest_ws']['uti_adh_id'];
		$uti_droits = $_SESSION['selest_ws']['uti_droits'];

		// démarrage de la transaction SQL
		$db->database->beginTransaction();





		/**
		 * D'abord, on récupère le type de la prestation (offre ou demande), l'ID de l'auteur, et l'état de la prestation (pour ne pas la re-valider)
		 */

		// préparation de la requête
		$query = "SELECT adh_id, adh_souets, ltp_nom AS pre_type, pre_souets, pre_date_realisation
			FROM prestation
			INNER JOIN liste_type_prestation ON ltp_id = pre_ltp_id
			INNER JOIN adherent ON adh_id = pre_adh_id
			WHERE pre_id = :pre_id";

		$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

		try{
			// lancement de la requête d'insertion du message
			$stmt->execute(array(
				':pre_id' => $pre_id
			));
			
			// récupération du résultat
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
			$adh_id = $result['adh_id'];
			$adh_souets = $result['adh_souets'];
			$pre_type = $result['pre_type'];
			$pre_souets = $result['pre_souets'];
			$pre_date_realisation = $result['pre_date_realisation'];

		} catch(PDOException $e) {

			stopWithError($e, "Erreur lors de la récupération des informations de la prestation", true);

		}

		
		// On ne valide pas une prestation déjà validée
		if($pre_date_realisation == null){
			
			// Seuls l'auteur de la prestation et l'adminstrateur peuvent valider une prestation
			if($uti_adh_id == $adh_id OR has_rights(RIGHTS_ADMIN)){
				
				$adh_ids = explode(',', $adh_ids_str);
				$nb_participants = count($adh_ids);
				
				// on vérifie que l'adhérent ne se trouve pas dans la liste des participants
				if(!in_array($uti_adh_id, $adh_ids)){
				
					
					/**
					 * Pour l'historique, on récupère le nombre de souets actuel de chaque participant
					 */

					// préparation de la requête pour les participants
					$query = "SELECT adh_id, adh_souets FROM adherent WHERE (FIND_IN_SET(CAST(adh_id AS CHAR), :liste_participants))";

					$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

					try{

						// lancement de la requête de mise à jour du montan de souets de chaque participant
						$stmt->execute(array(
							':liste_participants' => $adh_ids_str
						));

						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						
						// tableau associant 'adh_id' => 'adh_souets'
						$participants_nb_souets = array();
						foreach($result AS $ligne){
							$participants_nb_souets[$ligne['adh_id']] = $ligne['adh_souets'];
						}
						
					} catch(PDOException $e) {

						stopWithError($e, "Erreur lors de la récupération du nombre de souets des participants", true);

					}




					/**
					 * On transfère le nombre de souets aux participants.
					 * 
					 *  -> si c'est une  offre,  on ajoute - pre_souets (donc on enlève aux participants, on ajoute à l'adhérent)
					 *  -> si c'est une demande, on ajoute + pre_souets (donc on ajoute aux participants, on enlève à l'adhérent)
					 */
					
					if($pre_type == 'demande'){
						$pre_souets *= -1;
					}


					// préparation de la requête pour les participants
					$query = "UPDATE adherent SET adh_souets = adh_souets - :pre_souets
						WHERE adh_id IN (:liste_participants)";

					$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

					try{
						// lancement de la requête de mise à jour du montan de souets de chaque participant
						$stmt->execute(array(
							':pre_souets' => $pre_souets,
							':liste_participants' => $adh_ids_str
						));

					} catch(PDOException $e) {

						stopWithError($e, "Erreur lors du transfert des souets aux participants", true);

					}




					// préparation de la requête pour l'adhérent
					$query = "UPDATE adherent SET adh_souets = adh_souets + (:pre_souets * :nb_participants)
						WHERE adh_id = :adh_id";

					$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

					try{
						// lancement de la requête d'insertion du message
						$stmt->execute(array(
							':pre_souets' => $pre_souets,
							':nb_participants' => $nb_participants,
							':adh_id' => $uti_adh_id
						));

					} catch(PDOException $e) {

						stopWithError($e, "Erreur lors du transfert des souets de l'auteur de la prestation", true);

					}



					


					/**
					 * Enfin, on enregistre la date de réalisation de la prestation
					 */

					$pre_date_realisation = $_POST['pre_date_realisation'] ?? date("Y-m-d H:i:s");

					// préparation de la requête
					$query = "UPDATE prestation SET pre_date_realisation = :pre_date_realisation
						WHERE pre_id = :pre_id";

					try{

						$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

						// lancement de la requête de mise à jour de la date
						$stmt->execute(array(
							':pre_id' => $pre_id,
							':pre_date_realisation' => $pre_date_realisation
						));

					} catch(PDOException $e) {

						stopWithError($e, "Erreur lors de l'enregistrement de la date de réalisation de la prestation", true);

					}







					/**
					 * Et on récupère les nouvelles infos
					 */

					// préparation de la requête
					$query = "SELECT pre_date_realisation, adh_souets
						FROM prestation
						INNER JOIN adherent ON adh_id = pre_adh_id 
						WHERE pre_id = :pre_id";

					$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

					try{

						// lancement de la requête de mise à jour de la date
						$stmt->execute(array(
							':pre_id' => $pre_id
						));

						$result = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

					} catch(PDOException $e) {

						stopWithError($e, "Erreur lors de la récupération des nouvelles infos", true);

					}







					
					/**
					 * Puis on insère dans l'historique
					 */

					// préparation de la requête
					$query = "INSERT INTO historique (his_pre_id, his_adh_id, his_type_adherent, his_montant, his_solde_avant, his_solde_apres)
						VALUES (:his_pre_id, :his_adh_id, :his_type_adherent, :his_montant, :his_solde_avant, :his_solde_apres)";

					$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

					try{

						// lancement de la requête d'historique pour l'auteur
						$stmt->execute(array(
							':his_pre_id' => $pre_id,
							':his_adh_id' => $uti_adh_id,
							':his_type_adherent' => 'auteur',
							':his_montant' => $pre_souets,
							':his_solde_avant' => $adh_souets,
							':his_solde_apres' => ($adh_souets + ($nb_participants * $pre_souets))
						));


						// lancement de la requête d'historique pour chaque participant
						foreach($participants_nb_souets as $id_participant => $nb_souets){
								
							// lancement de la requête d'historique pour chaque participant
							$stmt->execute(array(
								':his_pre_id' => $pre_id,
								':his_adh_id' => $id_participant,
								':his_type_adherent' => 'participant',
								':his_montant' => $pre_souets,
								':his_solde_avant' => $nb_souets,
								':his_solde_apres' => ($nb_souets - $pre_souets)
							));

						}

					} catch(PDOException $e) {

						stopWithError($e, "Erreur lors de l'insertion dans l'historique", true);

					}






					



					// validation de la transaction SQL
					$db->database->commit();
					
					// succès
					$response["success"] = 1;
					$response["adherent"]["adh_souets_ancien_solde"] = $adh_souets;
					$response["adherent"]["adh_souets_nouveau_solde"] = $result['adh_souets'];
					$response["prestation"]["pre_date_realisation"] = $result['pre_date_realisation'];
					$response["prestation"]["pre_type"] = $pre_type;
					$response["prestation"]["pre_souets"] = $pre_souets;
					$response["prestation"]["nb_participants"] = $nb_participants;
					$code = CODE_CREATED_CONTENT;


		

				} else {
				
					$response["success"] = 0;
					$response["message"] = "Requête invalide - l'adhérent s'est ajouté dans la liste des participants";
					$code = CODE_BAD_REQUEST;

				}


			} else {
				
				$response["success"] = 0;
				$response["message"] = "Requête impossible - cet utilisateur n'est ni auteur de la prestation ni administrateur";
				$code = CODE_FORBIDDEN;

			}


		} else {

			// requête invalide
			$response["success"] = 0;
			$response["message"] = "Requête invalide - la prestation est déjà réalisée";
			$code = CODE_PRECONDITION_FAILED;

		}
			

		$db->close();
		$stmt->closeCursor();



	} else {

		// requête invalide
		$response["success"] = 0;
		$response["message"] = "Requête invalide - champs manquants";
		$code = CODE_BAD_REQUEST;

	}
	

	// envoi du résultat
	require_once __DIR__ . '/transaction/display_result.php';

?>
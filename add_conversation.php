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
			isset($_POST["id_destinataires"])
		AND isset($_POST["texte"])
	) {

		// paramètres obligatoires
		$uti_id_emetteur = $_SESSION['selest_ws']['uti_id'];
		
		$uti_id_destinataires = explode(',', $_POST['id_destinataires']); // transforme la chaîne en array

		// on vérifie que l'on n'envoie pas un message à soi-même
		if(!in_array($uti_id_emetteur, $uti_id_destinataires)){
			
			$mes_texte = $_POST['texte'];
			$con_nom = $_POST["texte"] ?? null;

			/*
			 * On vérifie s'il n'y a pas une conversation identique (avec les mêmes destinataires) :
			 *  -> On trie les IDs des destinataires par ordre croissant, et on les met sous forme de chaîne (IDs séparés par virgules)
			 *  -> On récupère toutes les conversations existantes : pour chaque conversation, on groupe les IDs de chaque utilisateur
			 *     participant, par ordre croissant, et on les met sous forme de chaîne (IDs séparés par virgules)
			 *  -> On vérifie si la chaîne Destinataires passée en paramètre existe dans le résultat de la requête
			 *     - si oui, la conversation existe, donc on utilisera la conversation existante
			 */

			$uti_id_destinataires[] = $uti_id_emetteur; // ajoute l'ID de l'utilisateur actuel
			$uti_id_destinataires = array_unique($uti_id_destinataires); // supprime les éventuels doublons
			sort($uti_id_destinataires); // trie les IDs par ordre croissant
			$destinataires = implode(',', $uti_id_destinataires); // remet sous forme de chaîne

			// démarrage de la transaction SQL
			$db->database->beginTransaction();

			// préparation de la requête
			$query = "SELECT con_id, destinataires FROM (
				SELECT
				con_id, GROUP_CONCAT(rcu_uti_id ORDER BY rcu_uti_id ASC SEPARATOR ',') AS destinataires
				FROM conversation
				INNER JOIN rel_conversation_utilisateur ON rcu_con_id = con_id
				GROUP BY con_id
			) AS liste
			WHERE destinataires = :destinataires";

			$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

			// lancement de la requête de recherche de conversation avec les mêmes destinataires
			$stmt->execute(array(
				':destinataires' => $destinataires
			));

			// S'il existe déjà une conversation avec les mêmes destinataires, on utilise celle-ci
			if($stmt->rowCount() > 0){

				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$con_id = $result[0]["con_id"];

				// on met à jour le nom de la conversation
				if(isset($con_nom)){

					// préparation de la requête
					$query = "UPDATE conversation SET con_nom = :con_nom";

					// préparation des paramètres
					$parametres = array(
						':con_nom' => $con_nom
					);

					$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

					try{

						// lancement de la requête 
						$stmt->execute($parametres);

					} catch(PDOException $e) {

						stopWithError($e, "Erreur lors du renommage de la conversation", true);
						
					}

				}

			} else {
				
				// sinon on en crée une nouvelle...
				
				// préparation de la requête
				$query = "INSERT INTO conversation (con_nom) VALUES (:con_nom)";

				// préparation des paramètres
				$parametres = array(
					':con_nom' => $con_nom
				);

				$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

				try{

					// lancement de la requête 
					$stmt->execute($parametres);

					// récupération de l'id inséré
					$con_id = $db->database->lastInsertId();

				} catch(PDOException $e) {

					stopWithError($e, "Erreur lors de la création de la conversation", true);
					
				}


				
				// ...et on y ajoute les destinataires
				
				// préparation de la requête
				$query = "INSERT INTO rel_conversation_utilisateur (rcu_con_id, rcu_uti_id) VALUES (:con_id, :uti_id)";

				$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

				try{

					// ajout de chaque utilisateur
					foreach($uti_id_destinataires as $uti_id){
						$stmt->execute(array(
							'con_id' => $con_id,
							'uti_id' => $uti_id
						));
					}

				} catch(PDOException $e) {	

					stopWithError($e, "Erreur lors de l'ajout des utilisateurs à la conversation", true);
					
				}

			}





			/**
			 * Enfin, on ajoute le message
			 */ 

			// préparation de la requête
			$query = "INSERT INTO message (mes_con_id, mes_uti_id_emetteur, mes_texte)
			VALUES (:mes_con_id, :mes_uti_id_emetteur, :mes_texte)";

			// préparation des paramètres
			$parametres = array(
				':mes_con_id' => $con_id,
				':mes_uti_id_emetteur' => $uti_id_emetteur,
				':mes_texte' => $mes_texte
			);

			$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

			try{
				// lancement de la requête d'insertion du message
				$stmt->execute($parametres);
				
				// récupération de l'id inséré
				$mes_id = $db->database->lastInsertId();

				// validation de la transaction SQL
				$db->database->commit();
				
				// succès
				$response["success"] = 1;
				$response["conversation"]["con_id"] = $con_id;
				$response["message"]["mes_id"] = $mes_id;
				$code = CODE_CREATED_CONTENT;

			} catch(PDOException $e) {

				stopWithError($e, "Erreur lors de l'ajout du message à la conversation", true);

			}


			$db->close();
			$stmt->closeCursor();

			
		} else {

			// requête invalide
			$response["success"] = 0;
			$response["message"] = "Requête invalide - impossible d'envoyer un message à soi-même";
			$code = CODE_BAD_REQUEST;
	
		}

	} else {

		// requête invalide
		$response["success"] = 0;
		$response["message"] = "Requête invalide - champs manquants";
		$code = CODE_BAD_REQUEST;

	}
	

	// envoi du résultat
	require_once __DIR__ . '/transaction/display_result.php';

?>
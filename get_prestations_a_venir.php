<?php
	
	/*
	* Récupère la liste des prestations à venir de l'adhérent
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// stopper l'exécution du script si l'utilisateur n'est pas connecté
	check_connection(RIGHTS_WRITER);
	

	// Si on a un ID d'adhérent passé en paramètre, c'est qu'on est un administrateur
	if(isset($_GET['id_adherent'])){
		check_connection(RIGHTS_ADMIN);
		$adh_id = $_GET['id_adherent'];
	} else {
		// Si aucun ID d'adhérent n'est passé, alors on regarde simplement les prestations de l'utilisateur actuellement connecté
		$adh_id = $_SESSION['selest_ws']['uti_adh_id'];
	}

	
	// préparation de la requête
	$query = 'SELECT
		pre_id,
		ltp_nom AS pre_type,
		pre_date_souhaitee_debut,
		pre_date_souhaitee_fin,
		pre_description,
		pre_souets,
		adh_id,
		adh_nom,
		adh_prenom
		FROM rel_prestation_adherent
		INNER JOIN prestation ON pre_id = rpa_pre_id
		INNER JOIN liste_type_prestation ON ltp_id = pre_ltp_id
		INNER JOIN adherent ON adh_id = pre_adh_id
		WHERE rpa_adh_id = :adh_id
		-- AND pre_date_realisation IS NULL
		ORDER BY pre_date_souhaitee_debut DESC';

	$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	
	try{
		
		// lancement de la requête
		$stmt->execute(array(
			':adh_id' => $adh_id
		));
		
		
		// récupération des résultats s'ils existent
		if($stmt->rowCount() > 0){
			
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


			/**
			 * Récupération des participants et classement des infos
			 */

			// préparation de la requête
			$query = 'SELECT
				adh_id,
				adh_nom,
				adh_prenom
				FROM prestation
				INNER JOIN rel_prestation_adherent ON rpa_pre_id = pre_id
				INNER JOIN adherent ON adh_id = rpa_adh_id
				WHERE pre_id = :pre_id
				AND adh_id != :adh_id
				';

			$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			
			foreach($result as $row_prestation){

				$prestation["prestation"] = array_filter_key_prefix($row_prestation, 'pre');
				$prestation["adherent"] = array_filter_key_prefix($row_prestation, 'adh');
				$prestation["participants"] = null;

				$pre_id = $prestation["prestation"]["pre_id"];

				try{
				
					// lancement de la requête
					$stmt->execute(array(
						':pre_id' => $pre_id,
						':adh_id' => $adh_id
					));

					if($stmt->rowCount() > 0){
						$prestation["participants"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
					}
					
				
				} catch(PDOException $e){

					stopWithError($e, "Echec de la récupération des participants à la prestation n°$pre_id");

				}

				$response["prestations"][] = $prestation;

			}

			// succès
			$response["success"] = 1;
			$code = CODE_OK;

			$db->close();
			$stmt->closeCursor();

		}

	} catch(PDOException $e){

		stopWithError($e, "Echec de la récupératon des prestations");

	}
	
	


	// envoi du résultat
	require_once __DIR__ . '/transaction/display_result.php';

?>
<?php
	
	/*
	* Récupération d'une prestation
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// stopper l'exécution du script si l'utilisateur n'est pas connecté
	check_connection(RIGHTS_WRITER);
	
	
	// vérification de la présence des données
	if (isset($_GET["pre_id"])) {
		$pre_id = $_GET['pre_id'];
		
		// préparation de la requête
		$query = 'SELECT pre_id,
			adh_id,
			adh_nom,
			adh_prenom,
			pre_cat_id,
			ltp_nom AS pre_type,
			pre_date_souhaitee_debut,
			pre_date_souhaitee_fin,
			pre_date_realisation,
			pre_description,
			pre_souets,
			pre_date_creation,
			pre_date_modification
			FROM prestation
			INNER JOIN adherent ON adh_id = pre_adh_id
			INNER JOIN liste_type_prestation ON ltp_id = pre_ltp_id
			WHERE pre_id = :pre_id';

		$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		
		try{
			
			// lancement de la requête
			$stmt->execute(array(
				':pre_id' => $pre_id
			));
			
			
			// récupération des résultats s'ils existent
			if($stmt->rowCount() > 0){
				
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
				
				$response["prestation"] = array_filter_key_prefix($result, 'pre');
				$response["adherent"] = array_filter_key_prefix($result, 'adh');
				
				


				/*
				 * Récupération des réponses à la prestation
				 */

				// préparation de la requête
				$query = 'SELECT
					adh_id,
					adh_nom,
					adh_prenom
					FROM prestation
					INNER JOIN rel_prestation_adherent ON rpa_pre_id = pre_id
					INNER JOIN adherent ON adh_id = rpa_adh_id
					WHERE pre_id = :pre_id';

				$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

				try{
				
					// lancement de la requête
					$stmt->execute(array(
						':pre_id' => $pre_id
					));
					$db->close();

					if($stmt->rowCount() > 0){
						$response["reponses"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
					}

					// succès
					$response["success"] = 1;
					$code = CODE_OK;
				
				} catch(PDOException $e){

					$response["success"] = 0;
					$response["error"] = $e->getCode();
					$response["message"] = $e->getMessage();
					$code = CODE_INTERNAL_SERVER_ERROR;
				}


			} else {
				
				// pas de donnée
				$response["success"] = 0;
				$response["message"] = "Aucun résultat";
				$code = CODE_NOT_FOUND;

			}

		} catch(PDOException $e){

			$response["success"] = 0;
			$response["error"] = $e->getCode();
			$response["message"] = $e->getMessage();
			$code = CODE_INTERNAL_SERVER_ERROR;
		}

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
<?php
	
	/*
	* Ajout d'une prestation
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// si la connexion à la base a fonctionné
	if($db->database){
		
		// vérification de la présence des données
		if (
				isset($_POST["pre_adh_id"])
			AND isset($_POST["pre_cat_id"])
			AND isset($_POST["pre_ltp_id"])
			AND isset($_POST["pre_description"])
			AND isset($_POST["pre_souets"])
		) {

			// paramètres obligatoires
			$pre_adh_id_auteur = $_POST['pre_adh_id'];
			$pre_cat_id = $_POST['pre_cat_id'];
			$pre_ltp_id = $_POST['pre_ltp_id'];
			$pre_description = $_POST['pre_description'];
			$pre_souets = $_POST['pre_souets'];

			// paramètres optionnels
			$pre_date_souhaitee_debut = $_POST['pre_date_souhaitee_debut'] ?? null;
			$pre_date_souhaitee_fin = $_POST['pre_date_souhaitee_fin'] ?? null;
			$pre_date_realisation = $_POST['pre_date_realisation'] ?? null;

			// préparation de la requête
			$query = "INSERT INTO prestation (pre_adh_id, pre_cat_id, pre_ltp_id, pre_date_souhaitee_debut, pre_date_souhaitee_fin, pre_date_realisation, pre_description, pre_souets)
				VALUES (:pre_adh_id, :pre_cat_id, :pre_ltp_id, :pre_date_souhaitee_debut, :pre_date_souhaitee_fin, :pre_date_realisation, :pre_description, :pre_souets)";

			// préparation des paramètres
			$parametres = array(
				':pre_adh_id' => $pre_adh_id,
				':pre_cat_id' => $pre_cat_id,
				':pre_ltp_id' => $pre_ltp_id,
				':pre_date_souhaitee_debut' => $pre_date_souhaitee_debut,
				':pre_date_souhaitee_fin' => $pre_date_souhaitee_fin,
				':pre_date_realisation' => $pre_date_realisation,
				':pre_description' => $pre_description,
				':pre_souets' => $pre_souets
			);

			$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

			try{

				// lancement de la requête 
				$stmt->execute($parametres);

				// récupération de l'id inséré
				$response["id"] = $db->database->lastInsertId();

				// succès
				$response["success"] = 1;
				$code = CODE_CREATED_CONTENT;

			} catch(PDOException $e) {

				// pas de donnée
				$response["success"] = 0;
				$response["error"] = $e->getCode();
				$response["message"] = $e->getMessage();
				$code = CODE_INTERNAL_SERVER_ERROR;

			}


			$db->close();
			$stmt->closeCursor();
			

		} else {

			// requête invalide
			$response["success"] = 0;
			$response["message"] = "Requête invalide - champs manquants";
			$code = CODE_BAD_REQUEST;

		}

	} else {
		
		// pas de donnée
		$response["success"] = 0;
		$response["message"] = "Impossible de contacter la base de données";
		$code = CODE_SERVICE_UNAVAILABLE;

	}


	// envoi du résultat
	require_once __DIR__ . '/transaction/display_result.php';

?>
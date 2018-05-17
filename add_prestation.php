<?php
	
	/*
	* Ajout d'une prestation
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// stopper l'exécution du script si l'utilisateur n'est pas connecté
	check_connection(RIGHTS_WRITER);
	

	// vérification de la présence des données
	if (
			isset($_POST["pre_cat_id"])
		AND isset($_POST["pre_type"])
		AND isset($_POST["pre_description"])
		AND isset($_POST["pre_souets"])
	) {

		if(user_is_adherent()){

			// paramètres obligatoires
			$pre_adh_id_auteur = $_SESSION['selest_ws']['uti_adh_id'];
			$pre_cat_id = $_POST['pre_cat_id'];
			$pre_type = $_POST['pre_type'];
			$pre_description = $_POST['pre_description'];
			$pre_souets = $_POST['pre_souets'];

			// paramètres optionnels
			$pre_date_souhaitee_debut = $_POST['pre_date_souhaitee_debut'] ?? null;
			$pre_date_souhaitee_fin = $_POST['pre_date_souhaitee_fin'] ?? null;

			// préparation de la requête
			$query = "INSERT INTO prestation (pre_adh_id, pre_cat_id, pre_ltp_id, pre_date_souhaitee_debut, pre_date_souhaitee_fin, pre_description, pre_souets)
				VALUES (:pre_adh_id, :pre_cat_id, (SELECT ltp_id FROM liste_type_prestation WHERE ltp_nom = :pre_type), :pre_date_souhaitee_debut, :pre_date_souhaitee_fin, :pre_description, :pre_souets)";

			// préparation des paramètres
			$parametres = array(
				':pre_adh_id' => $pre_adh_id_auteur,
				':pre_cat_id' => $pre_cat_id,
				':pre_type' => $pre_type,
				':pre_date_souhaitee_debut' => $pre_date_souhaitee_debut,
				':pre_date_souhaitee_fin' => $pre_date_souhaitee_fin,
				':pre_description' => $pre_description,
				':pre_souets' => $pre_souets
			);

			$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

			try{

				// lancement de la requête 
				$stmt->execute($parametres);

				// récupération de l'id inséré
				$response["prestation"]["pre_id"] = $db->database->lastInsertId();

				// succès
				$response["success"] = 1;
				$code = CODE_CREATED_CONTENT;

			} catch(PDOException $e) {

				stopWithError($e, "Echec de l'ajout de la prestation");

			}

			$db->close();
			$stmt->closeCursor();
			
		} else {
			
			// requête invalide
			$response["success"] = 0;
			$response["message"] = "L'utilisateur n'est pas un adhérent";
			$code = CODE_FORBIDDEN;

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
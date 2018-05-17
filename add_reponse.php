<?php
	
	/*
	* Ajout d'une réponse d'un adhérent à une prestation
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// stopper l'exécution du script si l'utilisateur n'est pas connecté
	check_connection(RIGHTS_WRITER);
	

	// vérification de la présence des données
	if (
			isset($_POST["pre_id"])
	) {

		if(user_is_adherent()){

			// paramètres obligatoires
			$pre_id = $_POST['pre_id'];
			$adh_id = $_SESSION['selest_ws']['uti_adh_id'];

			// préparation de la requête
			$query = "INSERT INTO rel_prestation_adherent (rpa_pre_id, rpa_adh_id)
				VALUES (:pre_id, :adh_id)";

			// préparation des paramètres
			$parametres = array(
				':pre_id' => $pre_id,
				':adh_id' => $adh_id
			);

			$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

			try{

				// lancement de la requête
				$stmt->execute($parametres);

				// succès
				$response["success"] = 1;
				$code = CODE_CREATED_NO_CONTENT;

			} catch (PDOException $e) {
				
				// pas de donnée
				$response["success"] = 0;
				$response["error"] = $e->getCode();
				$response["message"] = "Echec de l'ajout de la réponse à la prestation : ".$e->getMessage();
				$code = CODE_BAD_REQUEST;

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
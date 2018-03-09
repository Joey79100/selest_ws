<?php
	
	/*
	* Récupération d'un adhérent
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';



	// si la connexion à la base a fonctionné
	if($db->database){
		
		// vérification de la présence des données
		if (isset($_GET["adh_id"])) {
			$adh_id = $_GET['adh_id'];
			
			// préparation de la requête
			$query = 'SELECT adh_id, adh_prenom, adh_nom FROM adherent WHERE adh_id = :adh_id';

			$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$stmt->execute(array(
				':adh_id' => $adh_id
			));
			$db->close();
			
			
			// récupération des résultats s'ils existent
			if($stmt->rowCount() > 0){
				
				// récupération des résultats
				$response["adherents"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
				// succès
				$response["success"] = 1;
				$code = CODE_OK;

			} else {
				
				// pas de donnée
				$response["success"] = 0;
				$response["message"] = "Aucun résultat";
				$code = CODE_NOT_FOUND;

			}

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
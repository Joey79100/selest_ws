<?php
	
	/*
	* Ajout d'un adhérent
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// si la connexion à la base a fonctionné
	if($db->database){
		
		// vérification de la présence des données
		if (isset($_POST["cat_nom"])) {
			
			$cat_nom = $_POST['cat_nom'];

			// préparation de la requête
			$query = "INSERT INTO categorie (cat_nom) VALUES (:cat_nom)";

			// préparation des paramètres
			$parametres = array(':cat_nom' => $cat_nom);

			$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

			// lancement de la requête - si insertion ok...
			if($stmt->execute($parametres)){

				// récupération de l'id inséré
				$response["id"] = $db->database->lastInsertId();
				
				// succès
				$response["success"] = 1;
				$code = CODE_CREATED_CONTENT;

			} else {
				
				// pas de donnée
				$response["success"] = 0;
				$response["message"] = $db->database->errorCode();
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
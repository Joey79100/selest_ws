
<?php
	
	/*
	* Récupération d'un adhérent
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// vérification de la présence des données
	if (isset($_GET["adh_id"])) {
		$adh_id = $_GET['adh_id'];
		
		// préparation de la requête
		$query = "SELECT adh_prenom, adh_nom FROM adherent WHERE adh_id = ?";
		
		if ($stmt = mysqli_prepare($db->database, $query)) {

			// affectation des paramètres et lancement de la requête
			mysqli_stmt_bind_param($stmt, STMT_TYPE_STRING, $adh_id);
			mysqli_stmt_execute($stmt);

			$adh_nom = null;
			$adh_prenom = null;

			mysqli_stmt_bind_result($stmt, $adh_nom, $adh_prenom);

			// récupération des résultats s'ils existent
			if(mysqli_stmt_affected_rows($stmt) > 0){

				$response["adherents"] = array();
				while($stmt->fetch()){
					$element = array();
					$element["adh_nom"] = $adh_nom;
					$element["adh_prenom"] = $adh_prenom;

					array_push($response["adherents"], $element);
				}

				// succès
				$response["success"] = 1;
				$code = CODE_OK;

			} else {
				
				// pas de donnée
				$response["success"] = 0;
				$response["message"] = "Aucun résultat";
				$code = CODE_NOT_FOUND;

			}
			
		} else {
				
			// erreur
			$response["success"] = 0;
			$response["message"] = "Erreur interne";
			$code = CODE_INTERNAL_SERVER_ERROR;

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
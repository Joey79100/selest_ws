<?php
	
	/*
	* Description de la fonctionnalité
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// vérification de la présence des données
	if (isset($_GET["req_element_1"])) {
		$req_element_1 = $_GET['req_element_1'];
		

		// préparation de la requête
		$query = "SELECT row_1, row_2 FROM table_1 WHERE row_1 = ?";
		$stmt = mysqli_stmt_init($db->database);
		
		if ($stmt->prepare($query)) {
			// affectation des paramètres
			mysqli_stmt_bind_param($stmt, STMT_TYPE_STRING, $req_element_1);
			
			// lancement de la requête
			mysqli_stmt_execute($stmt);

			// récupération des résultats s'ils existent
			if(mysqli_stmt_affected_rows($stmt) > 0){

				$response["elements"] = array();
				while($row = mysqli_stmt_fetch($stmt)){
					$element = array();
					$element["element_row_1"] = $row["element_row_1"];
					$element["element_row_2"] = $row["element_row_2"];

					array_push($response["elements"], $element);
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
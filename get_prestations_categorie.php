<?php
	
	/*
	* Récupération des prestations (offres et demandes) actives d'une catégorie
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// si la connexion à la base a fonctionné
	if($db->database){

		// vérification de la présence des données
		if (isset($_GET["type"]) AND ($_GET["type"] == 'offre' OR $_GET["type"] == 'demande')) {
			
			$type_prestation = $_GET["type"];
			if($_GET["cat_id"])
				$cat_id = $_GET["cat_id"];

			// préparation de la requête
			$query = "SELECT pre_id, cat_id, cat_nom, pre_date_souhaitee_debut, pre_date_souhaitee_fin, pre_description, pre_souets
				FROM prestation
				INNER JOIN categorie ON pre_cat_id = cat_id
				INNER JOIN liste_type_prestation ON pre_ltp_id = ltp_id
				WHERE ltp_nom LIKE :type_prestation
				AND pre_date_realisation IS NULL
			";

			$parametres = array(
				':type_prestation' => $type_prestation,
			);

			if(isset($cat_id)){
				$query .= "AND pre_cat_id = :cat_id";
				$parametres[':cat_id'] = $cat_id;
			}

			$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

			$stmt->execute($parametres);
			$db->close();
			
			
			
			// récupération des résultats s'ils existent
			if($stmt->rowCount() > 0){

				// récupération des résultats
				$response["offres"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
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

			// requête invalide
			$response["success"] = 0;
			$response["message"] = "Requête invalide - champs manquants ou invalides";
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
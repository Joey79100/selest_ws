<?php
	
	/*
	* Récupération des catégories
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// si la connexion à la base a fonctionné
	if($db->database){

		// préparation de la requête
		$query = 'SELECT
			cat_id,
			cat_nom,
			(SELECT COUNT(*)
				FROM prestation
				INNER JOIN liste_type_prestation ON pre_ltp_id = ltp_id
				WHERE pre_cat_id = cat_id
				AND pre_date_realisation IS NULL
				AND ltp_nom LIKE "offre") AS cat_nombre_offres, 
			(SELECT COUNT(*)
				FROM prestation
				INNER JOIN liste_type_prestation ON pre_ltp_id = ltp_id
				WHERE pre_cat_id = cat_id
				AND pre_date_realisation IS NULL
				AND ltp_nom LIKE "demande") AS cat_nombre_demandes 
			FROM categorie
		';

		$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$stmt->execute();
		$db->close();
		
		
		
		// récupération des résultats s'ils existent
		if($stmt->rowCount() > 0){

			// récupération des résultats
			// $response["categories"] = array_map("utf8_encode", $stmt->fetchAll(PDO::FETCH_ASSOC));
			$response["categories"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
// echo '<pre>$response["categories"] : ';
// print_r($response["categories"]);
// echo '</pre>';
// die();

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
		
		// pas de donnée
		$response["success"] = 0;
		$response["message"] = "Impossible de contacter la base de données";
		$code = CODE_SERVICE_UNAVAILABLE;

	}
	

	// envoi du résultat
	require_once __DIR__ . '/transaction/display_result.php';

?>
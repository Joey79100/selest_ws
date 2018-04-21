<?php
	
	/*
	* Récupération des catégories
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';
	

	// stopper l'exécution du script si l'utilisateur n'est pas connecté
	check_connection(RIGHTS_WRITER);
	
	
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
		$response["categories"] = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// succès
		$response["success"] = 1;
		$code = CODE_OK;

	} else {
		
		// pas de donnée
		$response["success"] = 0;
		$response["message"] = "Aucun résultat";
		$code = CODE_NOT_FOUND;

	}
	

	// envoi du résultat
	require_once __DIR__ . '/transaction/display_result.php';

?>
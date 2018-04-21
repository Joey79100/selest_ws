<?php
	
	/*
	* Récupération des adhérents
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// stopper l'exécution du script si l'utilisateur n'est pas connecté
	check_connection(RIGHTS_WRITER);
	
	
	// préparation de la requête
	$query = 'SELECT adh_id, adh_prenom, adh_nom FROM adherent';

	$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$stmt->execute();
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


	// envoi du résultat
	require_once __DIR__ . '/transaction/display_result.php';

?>
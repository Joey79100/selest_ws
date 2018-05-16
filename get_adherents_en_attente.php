<?php
	
	/*
	* Récupération des adhérents n'ayant pas d'utilisateur associé (donc ne pouvant pas encore se connecter)
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// stopper l'exécution du script si l'utilisateur n'est pas connecté
	check_connection(RIGHTS_ADMIN);
	
	
	// préparation de la requête
	$query = 'SELECT adh_id, adh_prenom, adh_nom
		FROM adherent
		WHERE adh_id NOT IN (SELECT uti_adh_id FROM utilisateur WHERE uti_adh_id IS NOT NULL)
	';

	$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	
	try{
		
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
		
	} catch(PDOException $e){

		$response["success"] = 0;
		$response["error"] = $e->getCode();
		$response["message"] = $e->getMessage();
		$code = CODE_INTERNAL_SERVER_ERROR;
	}
	
	$stmt->closeCursor();

	// envoi du résultat
	require_once __DIR__ . '/transaction/display_result.php';

?>
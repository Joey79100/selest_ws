<?php
	
	/*
	* Récupération la liste des conversations d'un utilisateur
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// stopper l'exécution du script si l'utilisateur n'est pas connecté
	check_connection(RIGHTS_WRITER);
	
	
	// Si on a un ID d'émetteur passé en paramètre, c'est qu'on est un administrateur lisant les conversations d'un utilisateur
	if(isset($_GET["id_emetteur"])){
		check_connection(RIGHTS_ADMIN);
		$id_emetteur = $_GET["id_emetteur"];
	} else {
		// Si aucun ID d'utilisateur n'est passé, alors on regarde simplement les conversations de l'utilisateur actuellement connecté
		$id_emetteur = $_SESSION['selest_ws']['uti_id'];
	}

	// préparation de la requête
	$query = "SELECT con_id,
		(
			SELECT mes_texte
			FROM message
			WHERE mes_con_id = con_id
			ORDER BY mes_date DESC
			LIMIT 1
		) AS mes_texte,
		(
			SELECT COUNT(mes_id)
			FROM message
			WHERE mes_con_id = con_id
			AND mes_lu = 0
		) AS nb_messages_non_lus
		FROM conversation
		WHERE (:id_emetteur IN (con_uti_id_1, con_uti_id_2))
	";

	$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$stmt->execute(array(
		':id_emetteur' => $id_emetteur
	));
	$db->close();
	
	
	
	// récupération des résultats s'ils existent
	if($stmt->rowCount() > 0){

		// récupération des résultats
		$response["messages"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
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
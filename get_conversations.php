<?php
	
	/*
	* Récupération la liste des conversations d'un utilisateur
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// stopper l'exécution du script si l'utilisateur n'est pas connecté
	check_connection(RIGHTS_WRITER);
	
	
	// Si on a un ID d'émetteur passé en paramètre, c'est qu'on est un administrateur lisant les conversations d'un utilisateur
	if(isset($_GET["uti_id"])){
		check_connection(RIGHTS_ADMIN);
		$uti_id = $_GET["uti_id"];
	} else {
		// Si aucun ID d'utilisateur n'est passé, alors on regarde simplement les conversations de l'utilisateur actuellement connecté
		$uti_id = $_SESSION['selest_ws']['uti_id'];
	}

	// préparation de la requête
	$query = "SELECT con_id,
			con_nom,
			rcu_uti_id,
			rcu_nb_messages_non_lus,
			(
				SELECT mes_texte FROM message WHERE mes_con_id = con_id ORDER BY mes_date DESC LIMIT 1
			) AS mes_texte,
			(
				SELECT mes_date FROM message WHERE mes_con_id = con_id ORDER BY mes_date DESC LIMIT 1
			) AS mes_date
		FROM conversation
		INNER JOIN rel_conversation_utilisateur ON rcu_con_id = con_id
		WHERE rcu_uti_id = :rcu_uti_id
		ORDER BY mes_date DESC
	";

	$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$stmt->execute(array(
		':rcu_uti_id' => $uti_id
	));
	$db->close();
	
	
	
	// récupération des résultats s'ils existent
	if($stmt->rowCount() > 0){

		// récupération des résultats
		$response["conversations"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
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
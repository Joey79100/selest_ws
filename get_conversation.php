<?php
	
	/*
	* Récupération les messages entre deux utilisateurs
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// stopper l'exécution du script si l'utilisateur n'est pas connecté
	check_connection(RIGHTS_WRITER);
	

	// vérification de la présence des données
	if (isset($_GET["id_destinataire"])) {
		
		$id_destinataire = $_GET["id_destinataire"];
		$query_where = "";
		$args_additionnels = array();
		
		// Si on a un ID d'émetteur passé en paramètre, c'est qu'on est un administrateur lisant une conversation entre deux utilisateurs
		if(isset($_GET["id_emetteur"])){
			check_connection(RIGHTS_ADMIN);
			$id_emetteur = $_GET["id_emetteur"];
		} else {
			// Si aucun ID d'utilisateur n'est passé, alors on regarde simplement une conversation de l'utilisateur actuellement connecté
			$id_emetteur = $_SESSION['selest_ws']['uti_id'];
		}

		// Si on a un ID de message passé en paramètre, c'est qu'on veut les messages antérieurs à celui-ci
		if(isset($_GET["id_message"])){
			$id_message = $_GET["id_message"];
			$query_where .= " AND mes_id < :id_message";
			$args_additionnels[":id_message"] = $id_message;
		}

		// Si on a un nombre de messages indiqué, on le récupère, sinon on prend 10 par défaut
		if(isset($_GET["nb_messages"])){
			$nb_messages = $_GET["nb_messages"];
		} else {
			$nb_messages = 10;
		}

		/* 
			$query = "SELECT mes_id, mes_texte, mes_uti_id_emetteur, mes_uti_id_destinataire, mes_date
				FROM message
				WHERE ((mes_uti_id_emetteur LIKE :id_emetteur AND mes_uti_id_destinataire LIKE :id_destinataire)
				OR (mes_uti_id_destinataire LIKE :id_emetteur2 AND mes_uti_id_emetteur LIKE :id_destinataire2))
				$query_where
				ORDER BY mes_date DESC
				LIMIT :nb_messages
			";
		*/	

		// préparation de la requête
		$query = "SELECT mes_id,
			mes_uti_id_emetteur,
			mes_texte,
			mes_date,
			mes_lu
			FROM conversation
			INNER JOIN message ON mes_con_id = con_id
			WHERE (:id_emetteur IN (con_uti_id_1, con_uti_id_2) OR :id_destinataire IN (con_uti_id_1, con_uti_id_2))
			$query_where
			ORDER BY mes_date DESC
			LIMIT :nb_messages
		";

		$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$args = array(
			':id_emetteur' => $id_emetteur,
			':id_destinataire' => $id_destinataire,
			':nb_messages' => $nb_messages
		);
		$args = array_merge($args, $args_additionnels);
		$stmt->execute($args);
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

	} else {

		// requête invalide
		$response["success"] = 0;
		$response["message"] = "Requête invalide - champs manquants ou invalides";
		$code = CODE_BAD_REQUEST;

	}


	// envoi du résultat
	require_once __DIR__ . '/transaction/display_result.php';

?>
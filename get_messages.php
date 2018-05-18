<?php
	
	/*
	* Récupération les messages d'une conversation
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// stopper l'exécution du script si l'utilisateur n'est pas connecté
	check_connection(RIGHTS_WRITER);
	

	// vérification de la présence des données
	if (isset($_GET["id_conversation"])) {
		
		$id_conversation = $_GET["id_conversation"];
		$query_where = "";
		$parametres_additionnels = array();
		
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
			$parametres_additionnels[":id_message"] = $id_message;
		}

		// Si on a un nombre de messages indiqué, on le récupère, sinon on prend 10 par défaut
		if(isset($_GET["nb_messages"])){
			$nb_messages = $_GET["nb_messages"];
		} else {
			$nb_messages = 10;
		}




		/**
		 * Récupération des utilisateurs participant
		 */
		
		// préparation de la requête
		$query = "SELECT
			uti_id,
			uti_identifiant,
			uti_droits,
			adh_id,
			adh_nom,
			adh_prenom,
			adh_ville
			FROM rel_conversation_utilisateur
			INNER JOIN utilisateur ON uti_id = rcu_uti_id
			LEFT JOIN adherent ON adh_id = uti_adh_id
			WHERE rcu_con_id = :con_id
		";

		$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

		try{

			$stmt->execute($parametres = array(
				':con_id' => $id_conversation
			));
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$participants = array();
			foreach($result as $row){
				$participant = array();
				$participant['utilisateur'] = array_filter_key_prefix($row, 'uti');
				$participant['adherent'] = ($row['adh_id'] != null) ? array_filter_key_prefix($row, 'adh') : null;
				$participants[] = $participant;
			}

		} catch(PDOException $e) {

			stopWithError($e, "Erreur lors de la récupération des participants");

		}






		/**
		 * Récupération des messages
		 */
		
		// préparation de la requête
		$query = "SELECT mes_id,
			mes_uti_id_emetteur,
			mes_texte,
			mes_date
			FROM conversation
			INNER JOIN message ON mes_con_id = con_id
			WHERE con_id = :con_id
			$query_where
			ORDER BY mes_date DESC
			LIMIT :nb_messages
		";

		$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$parametres = array(
			':con_id' => $id_conversation,
			':nb_messages' => $nb_messages
		);
		$args = array_merge($parametres, $parametres_additionnels);


		try{

			$stmt->execute($parametres);
			$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch(PDOException $e) {

			stopWithError($e, "Erreur lors de la récupération des messages");

		}

		$db->close();
		
		
		
		// récupération des résultats s'ils existent
		if($stmt->rowCount() > 0){

			// récupération des résultats
			$response["participants"] = $participants;
			$response["messages"] = $messages;
			
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
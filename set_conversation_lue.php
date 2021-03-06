<?php
	
	/*
	* Marque tous les messages d'une conversation comme lus pour l'utilisateur
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// stopper l'exécution du script si l'utilisateur n'est pas connecté
	check_connection(RIGHTS_WRITER);
	

	// vérification de la présence des données
	if (
			isset($_POST["id_conversation"])
	) {

		// paramètres obligatoires
		$uti_id = $_SESSION['selest_ws']['uti_id'];
		$con_id = $_POST["id_conversation"];

		// préparation de la requête
		$query = "UPDATE rel_conversation_utilisateur SET
			rcu_nb_messages_non_lus = 0
			WHERE rcu_con_id = :con_id
			AND rcu_uti_id = :uti_id";

		$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

		try{

			// lancement de la requête 
			$stmt->execute(array(
				':con_id' => $con_id,
				':uti_id' => $uti_id
			));

			// succès
			$response["success"] = 1;
			$code = CODE_NO_CONTENT;

		} catch(PDOException $e) {

			stopWithError($e, "Echec du marquage de la conversation comme lue");

		}


		$db->close();
		$stmt->closeCursor();
		

	} else {

		// requête invalide
		$response["success"] = 0;
		$response["message"] = "Requête invalide - champs manquants";
		$code = CODE_BAD_REQUEST;

	}


	// envoi du résultat
	require_once __DIR__ . '/transaction/display_result.php';

?>
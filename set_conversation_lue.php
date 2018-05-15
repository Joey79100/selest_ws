<?php
	
	/*
	* Marque tous les messages d'une conversation comme lus
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
		$query = "UPDATE message SET
			mes_lu = 1
			WHERE mes_con_id = :con_id
			AND mes_uti_id_emetteur != :uti_id";

		$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

		try{

			// lancement de la requête 
			$stmt->execute(array(
				':con_id' => $con_id,
				':uti_id' => $uti_id
			));

			// succès
			$response["success"] = 1;
			$code = CODE_CREATED_NO_CONTENT;

		} catch(PDOException $e) {

			$response["success"] = 0;
			$response["error"] = $e->getCode();
			$response["message"] = $e->getMessage();
			$code = CODE_INTERNAL_SERVER_ERROR;

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
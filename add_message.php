<?php
	
	/*
	* Ajout d'un message
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// stopper l'exécution du script si l'utilisateur n'est pas connecté
	check_connection(RIGHTS_WRITER);
	
	
	// vérification de la présence des données
	if (
			isset($_POST["id_conversation"])
		AND isset($_POST["texte"])
	) {

		// paramètres obligatoires
		$mes_uti_id_emetteur = $_SESSION['selest_ws']['uti_id'];
		$con_id = $_POST['id_conversation'];
		$mes_texte = $_POST['texte'];


		// préparation de la requête
		$query = "INSERT INTO message (mes_con_id, mes_uti_id_emetteur, mes_texte)
		VALUES (:mes_con_id, :mes_uti_id_emetteur, :mes_texte)";

		// préparation des paramètres
		$parametres = array(
			':mes_con_id' => $con_id,
			':mes_uti_id_emetteur' => $mes_uti_id_emetteur,
			':mes_texte' => $mes_texte
		);

		$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

		try{
			// lancement de la requête d'insertion du message
			$stmt->execute($parametres);
			
			// récupération de l'id inséré
			$mes_id = $db->database->lastInsertId();

			// succès
			$response["success"] = 1;
			$response["message"]["mes_id"] = $mes_id;
			$code = CODE_CREATED_CONTENT;

		} catch (PDOException $e) {

			stopWithError($e, "Echec de l'ajout du message");

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
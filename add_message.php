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
			isset($_POST["mes_adh_id_destinataire"])
		AND isset($_POST["mes_texte"])
	) {

		// paramètres obligatoires
		$mes_adh_id_emetteur = $_SESSION['selest_ws']['uti_id'];
		$mes_adh_id_destinataire = $_POST['mes_adh_id_destinataire'];
		$mes_texte = $_POST['mes_texte'];

		// préparation de la requête
		$query = "INSERT INTO message (mes_adh_id_emetteur, mes_adh_id_destinataire, mes_texte)
			VALUES (:mes_adh_id_emetteur, :mes_adh_id_destinataire, :mes_texte)";

		// préparation des paramètres
		$parametres = array(
			':mes_adh_id_emetteur' => $mes_adh_id_emetteur,
			':mes_adh_id_destinataire' => $mes_adh_id_destinataire,
			':mes_texte' => $mes_texte
		);

		$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

		// lancement de la requête - si insertion ok...
		if($stmt->execute($parametres)){

			// récupération de l'id inséré
			$response["id"] = $db->database->lastInsertId();
			
			// succès
			$response["success"] = 1;
			$code = CODE_CREATED_CONTENT;

		} else {

			// pas de donnée
			$response["success"] = 0;
			$response["message"] = $db->database->errorCode();
			$code = CODE_INTERNAL_SERVER_ERROR;

		}

		print_r($stmt->errorInfo());

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
<?php
	
	/*
	* Ajout d'un adhérent
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// stopper l'exécution du script si l'utilisateur n'est pas connecté
	check_connection(RIGHTS_ADMIN);
	

	// vérification de la présence des données
	if (
			isset($_POST["uti_identifiant"])
		AND isset($_POST["uti_mot_de_passe"])
	) {
		
		$uti_identifiant = $_POST['uti_identifiant'];
		$uti_mot_de_passe = $_POST['uti_mot_de_passe'];
		$uti_droits = isset($_POST['uti_droits']) AND ($_POST['uti_droits'] === RIGHTS_ADMIN OR $_POST['uti_droits'] === RIGHTS_WRITER) ? $_POST['uti_droits'] : null;
		$uti_adh_id = $_POST['uti_adh_id'] ?? null;

		// Début d'une transaction, désactivation du mode autocommit
		$db->database->beginTransaction();

		// préparation de la requête
		$query = "INSERT INTO utilisateur (uti_identifiant, uti_mot_de_passe, uti_droits, uti_adh_id)
			VALUES (:uti_identifiant, :uti_mot_de_passe, :uti_droits, :uti_adh_id)";

		// préparation des paramètres
		$parametres = array(
			':uti_identifiant' => $uti_identifiant,
			':uti_mot_de_passe' => $uti_mot_de_passe,
			':uti_droits' => $uti_droits,
			':uti_adh_id' => $uti_adh_id
		);

		$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

		try{
			// lancement de la requête d'insertion de l'adhérent
			$stmt->execute($parametres);
			
			// récupération de l'id inséré
			$adh_id = $db->database->lastInsertId();

			// succès
			$response["success"] = 1;
			$response["utilisateur"]["uti_id"] = $uti_id;
			$code = CODE_CREATED_CONTENT;

		} catch (PDOException $e) {

			// pas de donnée
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
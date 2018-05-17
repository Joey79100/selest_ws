<?php
	
	/*
	* Ajout d'un adhérent
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// stopper l'exécution du script si l'utilisateur n'est pas connecté
	check_connection(RIGHTS_WRITER);
	

	// vérification de la présence des données
	if (
			isset($_POST["adh_nom"])
		AND isset($_POST["adh_prenom"])
		AND isset($_POST["adh_telephone"])
		AND isset($_POST["adh_mobile"])
		AND isset($_POST["adh_email"])
		AND isset($_POST["adh_adresse"])
		AND isset($_POST["adh_code_postal"])
		AND isset($_POST["adh_ville"])
	) {

		$adh_nom = $_POST['adh_nom'];
		$adh_prenom = $_POST['adh_prenom'];
		$adh_telephone = $_POST['adh_telephone'];
		$adh_mobile = $_POST['adh_mobile'];
		$adh_email = $_POST['adh_email'];
		$adh_adresse = $_POST['adh_adresse'];
		$adh_code_postal = $_POST['adh_code_postal'];
		$adh_ville = $_POST['adh_ville'];

		// préparation de la requête
		$query = "INSERT INTO adherent (adh_nom, adh_prenom, adh_telephone, adh_mobile, adh_email, adh_adresse, adh_code_postal, adh_ville, adh_souets)
			VALUES (:adh_nom, :adh_prenom, :adh_telephone, :adh_mobile, :adh_email, :adh_adresse, :adh_code_postal, :adh_ville, (SELECT par_valeur FROM parametres WHERE par_nom = 'nombre_initial_souets'))";

		// préparation des paramètres
		$parametres = array(
			':adh_nom' => $adh_nom,
			':adh_prenom' => $adh_prenom,
			':adh_telephone' => $adh_telephone,
			':adh_mobile' => $adh_mobile,
			':adh_email' => $adh_email,
			':adh_adresse' => $adh_adresse,
			':adh_code_postal' => $adh_code_postal,
			':adh_ville' => $adh_ville
		);

		$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

		try{
			// lancement de la requête d'insertion de l'adhérent
			$stmt->execute($parametres);
			
			// récupération de l'id inséré
			$adh_id = $db->database->lastInsertId();

			// succès
			$response["success"] = 1;
			$response["adherent"]["adh_id"] = $adh_id;
			$code = CODE_CREATED_CONTENT;

		} catch (PDOException $e) {

			stopWithError($e, "Echec de la création de l'adhérent");

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
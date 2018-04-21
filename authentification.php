<?php

	/*
	* Première authentification de l'utilisateur pour la session
	*/
		
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// vérification de la présence des données
	if (isset($_POST['identifiant']) AND isset($_POST['mot_de_passe'])) {
		
		$uti_identifiant = $_POST['identifiant'];
		$uti_mot_de_passe = $_POST['mot_de_passe'];
		

		// vérification que l'utilisateur existe
		$query = 'SELECT uti_identifiant FROM utilisateur WHERE uti_identifiant = :uti_identifiant';

		$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$stmt->execute(array(
			':uti_identifiant' => $uti_identifiant
		));
		


		// si l'utilisateur existe, on vérifie si son mot de passe est valide
		if($stmt->rowCount() == 1){
			
			// vérification que le mot de passe coïncide
			$query = 'SELECT uti_id, uti_droits FROM utilisateur WHERE uti_identifiant = :uti_identifiant AND uti_mot_de_passe = :uti_mot_de_passe';

			$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$stmt->execute(array(
				':uti_identifiant' => $uti_identifiant,
				':uti_mot_de_passe' => $uti_mot_de_passe
			));


			// si le mot de passe est valide, on renvoie un token
			if($stmt->rowCount() == 1){
				
				// récupération des infos de l'utilisateur
				$resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$uti_id = $resultat[0]['uti_id'];
				$uti_droits = $resultat[0]['uti_droits'];

				// génération d'un token et sauvegarde des infos de connexion de l'utilisateur
				$token = user_login($uti_id, $uti_droits);

				// envoi du token
				$response["success"] = 1;
				$response["token"] = $token;
				$code = CODE_OK;

			} else {
				
				// pas de donnée
				$response["success"] = 0;
				$response["message"] = "Mot de passe invalide";
				$code = CODE_NOT_FOUND;

			}
		
		} else {
			
			// pas de donnée
			$response["success"] = 0;
			$response["message"] = "Utilisateur non trouvé";
			$code = CODE_NOT_FOUND;

		}

		$stmt->closeCursor();
		$db->close();

	} else {

		// requête invalide
		$response["success"] = 0;
		$response["message"] = "Requête invalide - champs manquants";
		$code = CODE_BAD_REQUEST;

	}


	// envoi du résultat
	require_once __DIR__ . '/transaction/display_result.php';


?>
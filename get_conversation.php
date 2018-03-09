<?php
	
	/*
	* Récupération les messages entre deux adhérents
	*/
	
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';


	// si la connexion à la base a fonctionné
	if($db->database){

		// vérification de la présence des données
		if (isset($_GET["id_emetteur"]) AND isset($_GET["id_destinataire"])) {
			
			$id_emetteur = $_GET["id_emetteur"];
			$id_destinataire = $_GET["id_destinataire"];

			// préparation de la requête
			$query = "SELECT mes_id, mes_texte, mes_adh_id_emetteur, mes_adh_id_destinataire, mes_date
				FROM message
				WHERE (mes_adh_id_emetteur LIKE :id_emetteur AND mes_adh_id_destinataire LIKE :id_destinataire)
				OR (mes_adh_id_destinataire LIKE :id_emetteur AND mes_adh_id_emetteur LIKE :id_destinataire)
				ORDER BY mes_date
			";

			$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$stmt->execute(array(
				':id_emetteur' => $id_emetteur,
				':id_destinataire' => $id_destinataire
			));
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

	} else {
		
		// pas de donnée
		$response["success"] = 0;
		$response["message"] = "Impossible de contacter la base de données";
		$code = CODE_SERVICE_UNAVAILABLE;

	}


	// envoi du résultat
	require_once __DIR__ . '/transaction/display_result.php';

?>
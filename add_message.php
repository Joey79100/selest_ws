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
			isset($_POST["id_destinataire"])
		AND isset($_POST["texte"])
	) {

		// paramètres obligatoires
		$mes_uti_id_emetteur = $_SESSION['selest_ws']['uti_id'];
		$mes_uti_id_destinataire = $_POST['id_destinataire'];

		// on vérifie que l'on n'envoie pas un message à soi-même
		if($mes_uti_id_emetteur != $mes_uti_id_destinataire){

			$mes_texte = $_POST['texte'];

			/**
			 * D'abord on récupère l'ID de la conversation (s'il n'y a pas de conversation, on en crée une)
			 */

			// préparation de la requête
			$query = "SELECT con_id
				FROM conversation
				WHERE :mes_uti_id_emetteur IN (con_uti_id_1, con_uti_id_2) AND :mes_uti_id_destinataire IN (con_uti_id_1, con_uti_id_2)";

			// préparation des paramètres
			$parametres = array(
				':mes_uti_id_emetteur' => $mes_uti_id_emetteur,
				':mes_uti_id_destinataire' => $mes_uti_id_destinataire
			);

			$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

			// lancement de la requête de recherche de la conversation
			$stmt->execute($parametres);
			

			// Si on a trouvé une conversation correspondant, on récupère son ID
			if($stmt->rowCount() > 0){

				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$con_id = $result[0]["con_id"];

			} else {

				// On n'a pas trouvé de conversatin, on en crée une

				// préparation de la requête
				$query = "INSERT INTO conversation (con_uti_id_1, con_uti_id_2)
					VALUES (:con_uti_id_1, :con_uti_id_2)";

				// préparation des paramètres
				$parametres = array(
					':con_uti_id_1' => $mes_uti_id_emetteur,
					':con_uti_id_2' => $mes_uti_id_destinataire
				);

				$stmt = $db->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

				try{

					// lancement de la requête
					$stmt->execute($parametres);

					// récupération de l'id inséré
					$con_id = $db->database->lastInsertId();

				} catch (PDOException $e) {

					// échec de la création de l'utilisateur
					$response["success"] = 0;
					$response["error"] = $e->getCode();
					$response["message"] = $e->getMessage();
					$code = CODE_INTERNAL_SERVER_ERROR;

					// envoi du résultat
					require_once __DIR__ . '/transaction/display_result.php';

				}
				

			}




			/**
			 * Enfin, on ajoute le message
			 */ 

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

				// échec de la création de l'utilisateur
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
			$response["message"] = "Requête invalide - émetteur et récepteur identiques";
			$code = CODE_BAD_REQUEST;
	
		}

	} else {

		// requête invalide
		$response["success"] = 0;
		$response["message"] = "Requête invalide - champs manquants";
		$code = CODE_BAD_REQUEST;

	}
	

	// envoi du résultat
	require_once __DIR__ . '/transaction/display_result.php';

?>
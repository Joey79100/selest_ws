<?php
 
/*
 * Le code suivant initialise la transaction en préparant les codes réponse, les types de données passées, et la connexion à la base
 */

// array pour la réponse JSON
$response = array();


// intégration des constantes
require_once __DIR__ . '/constants.php';


// initialisation de la session
require_once __DIR__ . '/init_session.php';


// connexion à la base
require_once __DIR__ . '/../db_connect/db_connect.php';


// vérification que l'utilisateur est connecté
require_once __DIR__ . '/user_connect.php';


/*
 * Ici sont déclarées les quelques autres fonctions qui sont utilisées par certaines des requêtes
 */

/**
 * Retourne une copie du tableau excluant toutes les clés-valeurs dont la clé ne comporte pas le préfixe passé en paramètre.
 *
 * @param array $array
 * @param string $prefix
 * @return array
 */
function array_filter_key_prefix($array, $prefix){
	return array_filter($array, function($key) use($prefix){
		return preg_match('/^('.$prefix.'_)/i', $key);
	}, ARRAY_FILTER_USE_KEY);
}

/**
 * Stoppe l'exécution du script et envoie le message d'erreur.
 * Si une transaction était en cours, alors elle sera arrêtée.
 *
 * @param PDOException $exception
 * @param string $message
 * @param boolean $stopTransaction
 * @return void
 */
function stopWithError($exception, $message = "", $stopTransaction = false){

	global $response, $db;

	if($stopTransaction){

		// annulation de la transaction SQL
		$db->database->rollBack();

	}

	$response["success"] = 0;
	$response["error"] = $exception->getCode();
	$response["message"] = $message. " : ".$exception->getMessage();
	$code = CODE_INTERNAL_SERVER_ERROR;

	// envoi du résultat
	require_once __DIR__ . '/display_result.php';
	
}

?>
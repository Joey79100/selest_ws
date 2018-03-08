<?php
 
/*
 * Le code suivant initialise la transaction en préparant les codes réponse, les types de données passées, et la connexion à la base
 */

// array pour la réponse JSON
$response = array();


// codes réponse disponibles
define("CODE_OK", 200);							// trouvé
define("CODE_CREATED_CONTENT", 201);			// l'élément a été créé, retourne le contenu
define("CODE_CREATED_NO_CONTENT", 204);			// l'élément a été créé, ne retourne rien
define("CODE_BAD_REQUEST", 400);				// la requête est incorrecte
define("CODE_NOT_FOUND", 404);					// requête correcte mais aucun contenu
define("CODE_INTERNAL_SERVER_ERROR", 500);		// requête correcte mais un problème est survenu
define("CODE_NOT_IMPLEMENTED", 501);			// requête correcte mais pas encore implémentée


// liste des types de données pour les statements SQL
define("STMT_TYPE_INTEGER", "i");			// correspond à une variable de type entier
define("STMT_TYPE_DECIMAL", "d");			// correspond à une variable de type nombre décimal
define("STMT_TYPE_STRING", "s");			// correspond à une variable de type chaîne de caractères


// code réponse par défaut
$code = CODE_OK;


// connexion à la base
require_once __DIR__ . '/../db_connect/db_connect.php';
$db = new DB_CONNECT();

?>
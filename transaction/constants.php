<?php

/*
 * Ce fichier stocke les constantes utilisées par le webservice
 */

// codes réponse disponibles
define("CODE_OK", 200);							// trouvé
define("CODE_CREATED_CONTENT", 201);			// l'élément a été créé, retourne le contenu
define("CODE_CREATED_NO_CONTENT", 204);			// l'élément a été créé, ne retourne rien
define("CODE_BAD_REQUEST", 400);				// la requête est incorrecte
define("CODE_UNAUTHORIZED", 401);				// utilisateur non authentifié
define("CODE_FORBIDDEN", 403);					// page non accessible pour cet utilisateur
define("CODE_NOT_FOUND", 404);					// requête correcte mais aucun contenu
define("CODE_PRECONDITION_FAILED", 412);		// requête correcte mas pré-conditions non vérifiées
define("CODE_INTERNAL_SERVER_ERROR", 500);		// requête correcte mais un problème est survenu
define("CODE_NOT_IMPLEMENTED", 501);			// requête correcte mais pas encore implémentée
define("CODE_SERVICE_UNAVAILABLE", 503);		// base de données non disponible

// liste des types de données pour les statements SQL
define("STMT_TYPE_INTEGER", "i");				// correspond à une variable de type entier
define("STMT_TYPE_DECIMAL", "d");				// correspond à une variable de type nombre décimal
define("STMT_TYPE_STRING", "s");				// correspond à une variable de type chaîne de caractères

// droits utilisateur
define("RIGHTS_ADMIN", 'A');					// 'A' = Adminstrateur
define("RIGHTS_WRITER", 'W');					// 'W' = Utilisateur lambda (Writer)

// autres paramètres
define("TOKEN_LENGTH", 32);						// longueur utilisée pour les token


// code réponse par défaut
$code = CODE_OK;

?>
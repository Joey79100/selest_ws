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


?>
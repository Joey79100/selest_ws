<?php
 
/*
 * On envoie le résultat de la requête et on paramètre l'en-tête du document en JSON
 */

// echoing JSON response
echo json_encode($response);

header("HTTP/1.1 ".$code." "."");
header("Content-Type:application/json");

?>
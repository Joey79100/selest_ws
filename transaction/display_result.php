<?php
 
/*
 * Following code will send the result of the request and set the headers accordingly
 */

// echoing JSON response
echo json_encode($response);

header("HTTP/1.1 ".$code." "."");
header("Content-Type:application/json");

?>
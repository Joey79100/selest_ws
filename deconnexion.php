<?php

	/*
	* Première authentification de l'utilisateur pour la session
	*/
		
	// Préparaton des infos nécessaires pour la transaction
	require_once __DIR__ . '/transaction/init_transaction.php';

	// déconnexion de l'utilisateur
	user_logoff();

	// envoi du résultat
	require_once __DIR__ . '/transaction/display_result.php';


?>
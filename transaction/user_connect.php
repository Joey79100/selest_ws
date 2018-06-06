<?php

/**
 * Vérifie si un utilisateur est connecté
 *
 * @return boolean
 */
function is_connected(){

	//$headers = apache_request_headers();
	$token = $_POST['token'] ?? $_GET['token'] ?? null;

	// vérification que le token passé dans la requête existe bien pour cette session
	return (
			isset($token)
		AND isset($_SESSION['selest_ws']['token'])
		AND $_SESSION['selest_ws']['token'] == $token
		AND isset($_SESSION['selest_ws']['uti_id'])
		AND isset($_SESSION['selest_ws']['uti_droits'])
	);

}
 /* function is_connected(){

	$headers = apache_request_headers();

	// vérification que le token passé dans la requête existe bien pour cette session
	return (
			isset($headers['token'])
		AND isset($_SESSION['selest_ws']['token'])
		AND $_SESSION['selest_ws']['token'] == $headers['token']
		AND isset($_SESSION['selest_ws']['uti_id'])
		AND isset($_SESSION['selest_ws']['uti_droits'])
	);

} */

/**
 * Vérifie si l'utilisateur a les droits requis
 *
 * @param string $droits	Caractère définissant le niveaux de droits demandé :
 * 								'A' = Adminstrateur
 * 								'W' = Utilisateur lambda (Writer)
 * @return boolean
 */
function has_rights($droits){

	// vérification que le token passé dans la requête existe bien pour cette session
	return ($_SESSION['selest_ws']['uti_droits'] == RIGHTS_ADMIN) OR ($_SESSION['selest_ws']['uti_droits'] == $droits);

}


/**
 * Arrête l'exécution de la page si l'utilisateur n'est pas connecté ou qu'il n'a pas les droits requis
 * 
 * @param string $droits	Caractère définissant le niveaux de droits demandé :
 * 								'A' = Administrateur
 * 								'W' = Utilisateur lambda (Writer)
 * @param int $uti_id		ID de l'utilisateur sur lequel porte la requête.
 * 							Utile lorsqu'on doit vérifier, par exemple, qu'un utilisateur essaie de voir son propre profil et non pas celui de quelqu'un d'autre.
 * @return void
 */
function check_connection($droits, $uti_id = null){
	
	if(is_connected()){

		if(has_rights($droits)){

			return;

		} else {

			$response['success'] = 0;
			$response['message'] = "L'utilisateur n'a pas les droits nécessaires pour accéder à cette page";
			$code = CODE_FORBIDDEN;

		}

	} else {
		
		$response['success'] = 0;
		$response['message'] = "Une authentification est requise pour accéder à cette page";
		$code = CODE_UNAUTHORIZED;

	}

	require_once __DIR__ . '/display_result.php';
	exit();
	
}

/**
 * Déconnexion utilisateur
 * 
 * Efface les variables de session pour oublier la connexion utilisateur
 *
 * @return void
 */
function user_logoff(){
	session_unset();
}

/**
 * Connexion utilisateur
 * 
 * Stocke les variables de session pour mémoriser la connexion (authentifiée) de l'utilisateur pour cette session
 *
 * @param int 		$uti_id
 * @param string	$uti_droits
 * @param string	$uti_adh_id
 * @return string	Token
 */
function user_login($uti_id, $uti_droits, $uti_adh_id){

	user_logoff();

	$token = bin2hex(random_bytes(TOKEN_LENGTH));
	$_SESSION['selest_ws']['token'] = $token;
	$_SESSION['selest_ws']['uti_id'] = $uti_id;
	$_SESSION['selest_ws']['uti_droits'] = $uti_droits;
	$_SESSION['selest_ws']['uti_adh_id'] = $uti_adh_id;

	return $token;

}

/**
 * Retourne si l'utilisateur est adhérent ou non
 *
 * @return boolean
 */
function user_is_adherent(){
	return isset($_SESSION['selest_ws']['uti_adh_id']);
}
?>
<?php
 
/**
 * A class file to connect to database
 */
class DB_CONNECT {
	public $database = null;
	
    // constructor
    function __construct() {
        // connecting to database
        $this->connect();
    }
 
    // destructor
    function __destruct() {
        // closing db connection
        $this->close();
    }
 
    /**
     * Function to connect with database
     */
    function connect() {
        // import database connection variables
        require_once __DIR__ . '/db_config.php';
 
        // // connecting to database
		try{
			$this->database = new PDO(DB_ENGINE.':host='.DB_SERVER.';port='.DB_PORT.";dbname=".DB_DATABASE, DB_USER, DB_PASSWORD);
		} catch (PDOException $e) {
			$this->database = null;
			// die('Erreur de connexion : ' . $e->getMessage() . '<br/>');
		}

		// $database = new PDO(DB_ENGINE.':host='.DB_SERVER.';port='.DB_PORT.";dbname=".DB_DATABASE, DB_USER, DB_PASSWORD);
		// if($database) $this->database = $database;

        // returing connection cursor
        return $this->database;
    }
 
    /**
     * Function to close db connection
     */
    function close() {
        // closing db connection
        $this->database = null;
    }
 
}
 
?>
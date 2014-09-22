<?php

namespace Model;



require_once(realpath(dirname(__FILE__)."/constants/consts.php" ));

// ok dont look too closely at this code. Its something i put togeather from old code. 

class DatabaseHandler{

	// public function itShouldReturn10(){
	// 	return 10;
	// }

	public static $conn = null; // only has room for 1 connection 
	private static $connectionString = "";

	public static function init($host, $dbname){
		DatabaseHandler::$connectionString = "mysql:host=$host;dbname=$dbname";

	}

	//only connect if we havnt connected before.
	//uses conection info from: consts.php
	public static function connect(){

		DatabaseHandler::init(c_Con_Host, c_Con_DB);

		if (DatabaseHandler::$conn == null) {
			try {
				DatabaseHandler::$conn = new \PDO(DatabaseHandler::$connectionString, c_Con_User, c_Con_PW);
				
				//echo "<p>Connected to ".c_Con_DB." at ".c_Con_Host." successfully.</p>";

			} catch (PDOException $pe) {
				die("Could not connect to the database $dbname :" . $pe->getMessage());
			}
		}

		return DatabaseHandler::$conn;
	}
}
<?php

namespace Spela;

require_once(realpath(dirname(__FILE__)."/conststants/consts.php" ));


class Database{

	public static $conn = null;

	private static $connectionString = "";

	public static function init($host, $dbname){
		Database::$connectionString = "mysql:host=$host;dbname=$dbname";

	}

	//only conncet if we havnt conected before
	public static function connect(){

		if (Database::$conn == null) {
			try {
				Database::$conn = new \PDO(Database::$connectionString, c_Con_User, c_Con_PW);
				
				echo "<p>Connected to ".c_Con_DB." at ".c_Con_Host." successfully.</p>";

			} catch (PDOException $pe) {
				die("Could not connect to the database $dbname :" . $pe->getMessage());
			}
		}

		return Database::$conn;
	}
}

//Database::init(c_Con_Host, c_Con_DB); //Database::connect(); 
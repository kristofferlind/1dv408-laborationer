<?php

require_once(realpath(dirname(__FILE__)."/databaseHandler.php" ));

// user object stored in db
class User{
	public $name;
	public $pw;
	public $id;
	public function setFromArray($arr){
		$this->name = $arr['name'];
		$this->pw = $arr['pw'];
	}
}

class UserDAL{
	private $databaseHandler;

	public function __construct($databaseHandler) {
		$this->databaseHandler = $databaseHandler;
	}

	public function store(User &$user){
		$db = $this->databaseHandler->connect();

		$username = $user->name;
		$passhash = $user->pw;

		$sql = "INSERT INTO users (name,pwhash) VALUES (:username,:passhash)";
		$q = $db->prepare($sql);
		$q->execute(array(':username'=>$username, ':passhash'=>$passhash));

		// $user->id = 10; // TODO: fix
	}

	public function retrieveUserByName($userName){
		$db = $this->databaseHandler->connect();

		$sql = "SELECT * FROM users WHERE name ='$userName'";
		
		$stmt = $db->query($sql); 
		$row = $stmt->fetchObject();

		if($row === false) return null;

		$foundUser = new User();
		$foundUser->name = $row->name;
		$foundUser->id = $row->userId;
		$foundUser->pw = $row->pwhash;

		return $foundUser;
	}

	public function createUser($register) {
		$user = new User();
		$user->setFromArray($register);
		try {
			$this->store($user);
		} catch(Exception $e) {
			return false;
		}
		return true;
	}
}
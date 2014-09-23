<?php

require_once(realpath(dirname(__FILE__)."/databaseHandler.php" ));
require_once(realpath(dirname(__FILE__)."/userDAL.php" ));

class OfflineIdentyfierDAL{
	private $databaseHander;

	// public function getUserIdFromHash($offlineIdentyfier){
	// 	return 10;
	// }

	// stolen
	public function getRandomString($length = 6) {
		$validCharacters = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ+-*#&@!?";
		$validCharNumber = strlen($validCharacters);
		$result = "";
		for ($i = 0; $i < $length; $i++) {
			$index = mt_rand(0, $validCharNumber - 1);
			$result .= $validCharacters[$index];
		}
		
		return $result;
	}

	// puts a random string that can be used to identy the user into the database.
	public function setIdentyfierForUser(CurrentUser $user, $expireTime){
		$db = $this->databaseHander->connect();

		$keyString = $this->getRandomString(50); // make this a random string
		$userId = $user->id;
		$browserInfo = $user->browser;
		//$browserInfo = "aaaaaaaaaaa";

		

		$sql = "INSERT INTO offlineidentyfier (keystring,user,browser,expire) VALUES (:keyString,:userId,:browserInfo,:expireTime)";
		$q = $db->prepare($sql);
		$q->execute(array(':keyString'=>$keyString, ':userId'=>$userId, ':browserInfo'=>$browserInfo, ':expireTime'=>$expireTime));

		// var_dump($user);
		// die();

		return $keyString;
	}

	// users: {userId, name, pwhash}
	// offlineidentyfier: {keystring, user}

	public function getUserFromIdentyfier($identyfier, $browser){
		$db = $this->databaseHander->connect();

		$sql = "SELECT userId, name, pwhash, expire FROM users INNER JOIN offlineidentyfier ON userId=user WHERE keystring='$identyfier' AND browser='$browser'";
		
		$stmt = $db->query($sql); 
		$row = $stmt->fetchObject();

		if($row === false) return null;

		$foundUser = new User();
		$foundUser->name = $row->name;
		$foundUser->id = $row->userId;
		$foundUser->pw = $row->pwhash;
		$foundUser->expire = $row->expire; //!

		return $foundUser;
	}

	public function __construct($databaseHander) {
		$this->databaseHander = $databaseHander;
	}
}
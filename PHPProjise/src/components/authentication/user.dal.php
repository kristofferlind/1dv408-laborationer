<?php

class UserDAL extends BaseDAL {

	//Should really be renamed, every other operation of this type is called get
	public function retrieveUserByCredentials(User $loginUser) {
		$db = $this->connection();
		$sql = 'SELECT * FROM users WHERE username = :username AND password = :password';
		$params = array(':username' => $loginUser->username, ':password' => $loginUser->password);
		$query = $db->prepare($sql);
		$query->execute($params);
		$dbUser = $query->fetchObject();

		if ($dbUser === false) {
			return null;
		}

		$returnUser = $this->createUserObject($dbUser);

		return $returnUser;
	}

	//Update token, expiration and user agent
	public function updateUserInfo($userAgent, $token, $expiration, $userId) {
		$db = $this->connection();
		$sql = 'UPDATE users SET userAgent = :userAgent, token = :token, expiration = :expiration WHERE userId = :userId';
		$params = array(':userAgent' => $userAgent, ':token' => $token, ':expiration' => $expiration, ':userId' => $userId);
		$query = $db->prepare($sql);
		$status = $query->execute($params);

		//Was it successful?
		return $status;
	}

	//Fetch user by name
	public function retrieveUserByName($username) {
		$db = $this->connection();
		$sql = 'SELECT * FROM users WHERE username = :username';
		$params = array(':username' => $username);
		$query = $db->prepare($sql);
		$query->execute($params);
		$user = $query->fetchObject();

		if ($user === false) {
			return null;
		}

		$returnUser = $this->createUserObject($user);

		return $returnUser;
	}

	//Fetch user by token (cookie login)
	public function retrieveUserByToken($token) {
		$db = $this->connection();
		$sql = 'SELECT * FROM users WHERE token = :token';
		$params = array(':token' => $token);
		$query = $db->prepare($sql);
		$query->execute($params);
		$user = $query->fetchObject();

		if ($user === false) {
			return null;
		}

		$returnUser = $this->createUserObject($user);

		return $returnUser;
	}

	//Create user
	public function createUser(User $user) {
		$db = $this->connection();
		$sql = 'INSERT INTO users (username, password, salt, userAgent, token, expiration) VALUES (:username, :password, :salt, :userAgent, :token, :expiration)';
		$params = array(':username'=>$user->username, ':password'=>$user->password, ':salt'=>$user->salt, ':userAgent' => $user->userAgent, ':token' => $user->token, ':expiration' => $user->expiration);
		$query = $db->prepare($sql);
		$query->execute($params);

		if ($query === false) {
			return null;
		}

		return $user;
	}

	//Make user object
	private function createUserObject($user) {
		return new User($user->username, $user->password, $user->userAgent, $user->salt, $user->userId, true, $user->token, $user->expiration);
	}
}
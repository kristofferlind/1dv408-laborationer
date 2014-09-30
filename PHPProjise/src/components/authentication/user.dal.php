<?php

class UserDAL extends BaseDAL {

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

	private function createUserObject($user) {
		return new User($user->username, $user->password, $user->userAgent, $user->salt, $user->userId, true, $user->token, $user->expiration);
	}
}
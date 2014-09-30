<?php

class User {
	public $userId;
	public $username;
	public $password;
	public $userAgent;
	public $token;
	public $salt;
	public $expiration;

	public function __construct($username, $password, $userAgent, $salt = '', $userId = '', $isFromDB = false, $token = '', $expiration = '') {
		if ($isFromDB) {
			//create from db fields
			$this->createFromDB($userId, $username, $password, $userAgent, $token, $salt, $expiration);
		} else {
			//create/load from client fields
			$this->createFromClient($username, $password, $userAgent, $salt);
		}
	}

	private function createFromDB($userId, $username, $password, $userAgent, $token, $salt, $expiration) {
		$this->userId = $userId;
		$this->username = $username;
		$this->password = $password;
		$this->userAgent = $userAgent;
		$this->token = $token;
		$this->salt = $salt;
		$this->expiration = $expiration;
	}

	private function createFromClient($username, $password, $userAgent, $salt) {
		if ($salt !== '') {
			//load
			$this->salt = $salt;
		} else {
			//create
			$this->salt = $this->createSalt();
		}

		$this->userId = '';
		$this->username = $username;
		$this->password = $this->hashPassword($password, $this->salt);
		$this->userAgent = $userAgent;
		$this->password = $this->hashPassword($password, $this->salt);
		$this->token = $this->generateToken();
		$this->expiration = $this->getExpiration();
	}

	private function createSalt() {
		return $salt = uniqid(mt_rand(), true);
	}

	private function hashPassword($password, $salt) {
		return crypt($password, '$6$rounds=5000$' . $salt . '$');
	}

	private function generateToken() {
		return $token = uniqid(mt_rand(), true);
	}

	private function getExpiration() {
		return time()+(60*60*24*30);
	}

	public function comparePassword(User $otherUser) {
		if ($this->password === $otherUser->password) {
			return true;
		} else {
			return false;
		}
	}
}
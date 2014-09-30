<?php

class AccountLoginModel extends BaseModel {
	private $userDAL;

	public function getToken() {
		return $_SESSION['user']->token;
	}

	public function getExpiration() {
		return $_SESSION['user']->expiration;
	}

	public function validateCredentials($username, $password, $remember, $userAgent) {
		$user = $this->userDAL->retrieveUserByName($username);
		$loginUser = new User($username, $password, $userAgent, $user->salt);
		$dbUser = $this->userDAL->retrieveUserByCredentials($loginUser);
		if ($dbUser === null) {
			$this->notify->error('Username and/or password were incorrect.');
			return false;
		}

		$this->notify->success('Login was successful.');
		$_SESSION['user'] = $dbUser;
		return true;
	}

	public function __construct() {
		parent::__construct();
		$this->userDAL = new UserDAL();
	}
}
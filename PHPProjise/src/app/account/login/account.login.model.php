<?php

class AccountLoginModel extends BaseModel {
	private $userDAL;

	//Fetch token (used for remembering users via cookies)
	public function getToken() {
		return $_SESSION['user']->token;
	}

	//Fetch token expirationdate
	public function getExpiration() {
		return $_SESSION['user']->expiration;
	}

	//Validates input credentials
	public function validateCredentials($username, $password, $remember, $userAgent) {
		//We need salt from user to correctly hash password
		$user = $this->userDAL->retrieveUserByName($username);
		$loginUser = new User($username, $password, $userAgent, $user->salt);
		$dbUser = $this->userDAL->retrieveUserByCredentials($loginUser);

		//Was there any user with these credentials?
		if ($dbUser === null) {
			$this->notify->error('Username and/or password were incorrect.');
			return false;
		}

		$this->notify->success('Login was successful.');
		$_SESSION['user'] = $dbUser;
		return true;
	}

	public function __construct() {
		//Parent constructor is overwritten by this one, and we want it to do some stuff
		parent::__construct();
		$this->userDAL = new UserDAL();
	}
}
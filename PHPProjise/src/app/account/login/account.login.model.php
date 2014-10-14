<?php

class AccountLoginModel extends BaseModel {
	private $userDAL;

	//Fetch token (used for remembering users via cookies)
	public function getToken() {
		return $this->user->token;
	}

	//Fetch token expirationdate
	public function getExpiration() {
		return $this->user->expiration;
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

		//Need to update user info (token, user-agent and token expiration)
		$updateStatus = $this->userDAL->updateUserInfo($loginUser->userAgent, $loginUser->token, $loginUser->expiration, $dbUser->userId);

		//Update successful?
		if ($updateStatus) {
			$loggedInUser = new User($dbUser->username, $dbUser->password, $loginUser->userAgent, $dbUser->salt, $dbUser->userId, true, $loginUser->token, $loginUser->expiration);
			$this->notify->success('Login was successful.');
			$this->setUser($loggedInUser);
			return true;
		} else {
			$this->notify->error('Something went wrong.');
			return false;
		}
	}

	public function __construct() {
		//Parent constructor is overwritten by this one, and we want it to do some stuff
		parent::__construct();
		$this->userDAL = new UserDAL();
	}
}
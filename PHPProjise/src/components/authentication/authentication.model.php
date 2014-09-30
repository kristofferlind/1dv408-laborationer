<?php

//maybe just use accountmodel?
class AuthenticationModel extends BaseModel {

	private $userDAL;

	//Called from BaseController so any requested url can try to log in using cookie
	//Tries to log in user using token
	public function tryLoadFromToken($token, $userAgent) {
		if (isset($_SESSION['user'])) {
			return true;
		}

		$tokenUser = $this->userDAL->retrieveUserByToken($token);
		if ($tokenUser === null) {
			return false;
		}

		if ($tokenUser->expiration < time()) {
			$this->notify->info('Login info is too old, you need to log in again.');
			return false;
		}

		if ($tokenUser->userAgent !== $userAgent) {
			return false;
		}

		$this->notify->success('Logged in using cookies.');
		$_SESSION['user'] = $tokenUser;
		return true;
	}

	public function isLoggedIn() {
		if (isset($_SESSION['user'])) {
			return true;
		} else {
			return false;
		}
	}

	public function __construct() {
		parent::__construct();
		$this->userDAL = new UserDAL();
	}
}
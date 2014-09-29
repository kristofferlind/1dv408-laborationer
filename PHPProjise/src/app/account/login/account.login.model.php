<?php

class AccountLoginModel extends BaseModel {
	private $accountDAL;
	public function validateCredentials($username, $password, $remember, $userAgent) {
		$user = $this->accountDAL->retrieveUserByCredentials($username, $password);
		if ($user === null) {
			$this->notify->error('Username and/or password were incorrect.');
			return false;
		}

		$this->notify->success('Login was successful.');
		$_SESSION['user'] = $user;
		return true;
	}

	public function __construct() {
		parent::__construct();
		$this->accountDAL = new AccountDAL();
	}
}
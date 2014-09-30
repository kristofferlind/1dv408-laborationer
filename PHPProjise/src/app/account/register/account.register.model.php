<?php

class AccountRegisterModel extends BaseModel {
	private $accountDAL;

	public function tryRegister($username, $password, $userAgent) {
		$existingUser = $this->accountDAL->retrieveUserByName($username);
		if ($existingUser !== null) {
			return 'Username is already in use, please choose another.';
		}
		$user = new User($username, $password, $userAgent);
		$registeredUser = $this->accountDAL->createUser($user);

		if ($registeredUser) {
			return true;
		} else {
			$this->notify->error('Something went wrong.');
			return false;
		}
	}

	public function __construct() {
		parent::__construct();
		$this->accountDAL = new AccountDAL();
	}
}
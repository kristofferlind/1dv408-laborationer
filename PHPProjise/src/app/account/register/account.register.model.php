<?php

class AccountRegisterModel extends BaseModel {
	private $accountDAL;

	public function tryRegister($username, $password, $userAgent) {
		$existingUser = $this->userDAL->retrieveUserByName($username);
		if ($existingUser !== null) {
			return 'Username is already in use, please choose another.';
		}
		$user = new User($username, $password, $userAgent);
		$registeredUser = $this->userDAL->createUser($user);

		if ($registeredUser) {
			return true;
		} else {
			$this->notify->error('Something went wrong.');
			return false;
		}
	}

	public function __construct() {
		parent::__construct();
		$this->userDAL = new UserDAL();
	}
}
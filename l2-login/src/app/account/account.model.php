<?php

class AccountModel {
	private $adminUsername;
	private $adminPassword;
	public $notifications;
	private $notify;
	private $accountDAL;
	public $token;
	public $tokenExpiration;

	public function __construct($notify) {
		$this->notify = $notify;
		$username = 'Admin';
		$password = 'Password';

		$this->adminUsername = $username;
		$this->adminPassword = crypt($password, $username);

		$this->accountDAL = new AccountDAL();
	}

	public function logout() {
		session_destroy();
		session_start();
		$this->notify->info('Du är nu utloggad.');
	}

	public function IsLoggedIn($userAgent) {
		if (!isset($_SESSION['username'])) { // || !isset($_SESSION['password'])) {
			return false;
		}

		$username = $_SESSION['username'];
		// $password = $_SESSION['password'];
		if ($username == $this->adminUsername && $_SESSION['userAgent'] == $userAgent) { // && $password == $this->adminPassword) {
			return true;
		} else {
			return false;
		}
	}

	public function validateToken($token) {
		$result = $this->accountDAL->findRememberedUser($token);
		if ($result != false) {
			$_SESSION['username'] = $result;
			return true;
		}
		
		return false;
	}

	public function validateCredentials($username, $password, $remember, $userAgent) {
		if ($username == '') {
			$this->notify->error('Användarnamn saknas.');
			return false;
		}

		if ($password == '') {
			$this->notify->error('Lösenord saknas.');
			return false;
		}

		if ($username != $this->adminUsername || $password != $this->adminPassword) {
			$this->notify->error('Felaktigt användarnamn och/eller lösenord');
			return false;
		}

		if ($remember == true) {
			$this->rememberUser($username);
		}

		$this->notify->success('Inloggning lyckades.');
		$_SESSION['username'] = $username;
		$_SESSION['userAgent'] = $userAgent;
		// $_SESSION['password'] = $password;
		return true;
	}

	private function rememberUser($username) {
		$expiration = time()+(60*60*24*30);
		$token = $this->createToken($username, $expiration);
		$this->accountDAL->rememberUser($token, $username, $expiration);
		$this->token = $token;
		$this->tokenExpiration = $expiration;
	}

	private function createToken($username, $expiration) {
		return crypt($username, $expiration . 'secret string appended to make it harder to calculate');
	}
}
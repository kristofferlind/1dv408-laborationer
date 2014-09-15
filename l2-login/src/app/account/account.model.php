<?php

class AccountModel {
	private $adminUsername;// = 'Admin';
	private $adminPassword;// = crypt('Password', $username);
	public $notifications;
	private $notify;

	public function __construct($notify) {
		$this->notify = $notify;
		$username = 'Admin';
		$password = 'Password';

		$this->adminUsername = $username;
		$this->adminPassword = crypt($password, $username);
	}

	public function logout() {
		session_destroy();
		session_start();
		$this->notify->info('Du är nu utloggad.');
	}

	public function IsLoggedIn($username, $password) {
		if ($username == $this->adminUsername && $password == $this->adminPassword) {
			return true;
		} else {
			return false;
		}
	}

	public function validateCredentials($username, $password) {

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


		$this->notify->success('Inloggning lyckades.');
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		return true;
	}
}
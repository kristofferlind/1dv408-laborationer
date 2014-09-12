<?php

class AccountModel {
	private $adminUsername = 'Admin';
	private $adminPassword = 'Password';
	public $notifications;
	private $notify;

	public function __construct($notify) {
		$this->notifications = new CookieService();
		$this->notify = $notify;
	}

	public function isLoggedIn() {
		if (isset($_SESSION['loggedIn'])) {
			return $_SESSION['loggedIn'];
		} else {
			return false;
		}
	}

	public function validateLogin() {

		if (!isset($_POST['username']) || $_POST['username'] == '') {
			// $this->notifications->save('Användarnamn saknas.');
			$this->notify->error('Användarnamn saknas.');
			return false;
		}

		if (!isset($_POST['password']) || $_POST['password'] == '') {
			// $this->notifications->save('Lösenord saknas.');
			$this->notify->error('Lösenord saknas.');
			return false;
		}

		$username = $_POST['username'];
		$password = $_POST['password'];

		if ($username != $this->adminUsername || $password != $this->adminPassword) {
			$this->notify->error('Felaktigt användarnamn och/eller lösenord');
			return false;
		}


		$this->notify->success('Inloggning lyckades.');
		$_SESSION['loggedIn'] = true;
		return true;
	}

	public function logout() {
		session_destroy();
		session_start();
		$this->notify->info('Du är nu utloggad.');
	}
}
<?php

class AccountView {

	private $model;
	public $cookieService;

	public function getUsername() {
		if (isset($_POST['username'])) {
			$this->cookieService->save('username', $_POST['username']);
			return $_POST['username'];
		}
		
		return '';
	}

	public function getPassword() {
		if (isset($_POST['password']) && $_POST['password'] != '') {
			return $password = crypt($_POST['password'], $this->getUsername());
		}

		return '';
	}

	public function getRemember() {
		if (isset($_POST['remember'])) {
			return $_POST['remember'];
		} else {
			return false;
		}
	}

	public function remember() {
		$token = $this->model->token;
		$expiration = $this->model->tokenExpiration;
		$this->cookieService->saveToken($token, $expiration);
	}

	public function getToken() {
		if ($this->cookieService->load('token') != '') {
			return $this->cookieService->load('token');
		} else {
			return '';
		}
	}

	public function removeToken() {
		$this->cookieService->remove('token');
	}

	public function getUserAgent() {
		return $_SERVER['HTTP_USER_AGENT'];
	}

	public function __construct($model, $cookieService) {
		$this->model = $model;
		$this->cookieService = $cookieService;
	}

	public function didLogin() {
		if (isset($_POST['login'])) {
			return true;
		} else {
			return false;
		}
	}

	public function didLogout() {
		if (isset($_GET['action']) && $_GET['action'] == 'logout') {
			$this->cookieService->remove('token');
			return true;
		} else {
			return false;
		}
	}

	public function redirect() {
		header('Location: ' . $_SERVER['PHP_SELF']);
	}

	public function login() {
		$username = $this->cookieService->load('username');;

		// if (isset($_POST['username'])) {
		// 	$username = $_POST['username'];
		// }

		$body = "
				<h1>L2 - Login [kl222jy]</h1>
				<a href='?action=register'>Registrera en ny användare</a>
				<h2>Ej inloggad</h2>
				<form action='?' method='post'>
					<fieldset>
						<legend>Inloggning - Skriv in användarnamn och lösenord</legend>
						<label for='username'>Username</label>
						<input type='text' id='username' name='username' value='$username'>
						<label for='password'>Password</label>
						<input type='password' id='password' name='password'>
						<label for='remember'>Håll mig inloggad</label>
						<input type='checkbox' id='remember' name='remember'>
						<button type='submit' name='login' class='btn btn-primary'>Logga in</button>
					</fieldset>
				</form>";

		return $body;
	}

	public function loggedIn() {
		$body = "
			<h1>L2 - Login [kl222jy]</h1>
			<h2>Admin är inloggad</h2>
			<a href='?action=logout'>Logga ut</a>";
		
		return $body;
	}
}
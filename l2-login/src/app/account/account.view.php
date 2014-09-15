<?php

class AccountView {

	private $model;
	public $cookieService;

	public function __construct($model) {
		$this->model = $model;
		$this->cookieService = new CookieService();
	}

	public function didLogin() {
		if (isset($_POST['login'])) {
			return true;
		} else {
			return false;
		}
	}

	public function redirect($location) {
		header('Location: ' . $location);
	}

	public function login() {
		$username = '';

		if (isset($_POST['username'])) {
			$username = $_POST['username'];
		}

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
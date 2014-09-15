<?php

class AccountController {

	private $model;
	private $view;
	private $username;
	private $password;

	public function __construct($model, $view) {
		$this->model = $model;
		$this->view = $view;
	}

	private function checkCredentials() {
		$username;
		$password;

		if (isset($_POST['username']) && isset($_POST['password'])) {
			$username = $_POST['username'];
			$password = crypt($_POST['password'], $username);
			
			if (isset($_POST['remember']) && $_POST['remember'] == true) {
				$this->view->cookieService->save('username', $username);
				$this->view->cookieService->save('password', $password);
			}
			
			//password_hash($password, PASSWORD_BCRYPT); borde användas, men stöds inte på mitt webbhotell
			return $this->model->validateCredentials($username, $password);
		}

		if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
			$username = $_SESSION['username'];
			$password = $_SESSION['password'];
			return $this->model->isLoggedIn($username, $password);
		}

		if ($this->view->cookieService->load('username') != '' && $this->view->cookieService->load('password') != '') {
			$username = $this->view->cookieService->load('username');
			$password = $this->view->cookieService->load('password');
			return $this->model->isLoggedIn($username, $password);
		}

		return false;
	}

	public function index() {
		//Check if user wants to log out
		if (isset($_GET['action']) && $_GET['action'] == 'logout') {
			$this->view->cookieService->remove('username');
			$this->view->cookieService->remove('password');
			$this->model->logOut();
		}

		//Check credentials
		if ($this->checkCredentials()) {
			return $this->view->loggedIn();
		} else {
			return $this->view->login();
		}

		return $this->view->login();
	}
}
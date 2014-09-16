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

	//validate login
	private function validateLogin() {
		//Make sure username and password exists
		if ($this->view->getUsername() == '' || $this->view->getPassword() == '') {
			return false;
		}

		$username = $this->view->getUsername();
		$password = $this->view->getPassword();

		$remember = $this->view->getRemember();

		if ($this->model->validateCredentials($username, $password, $remember, $this->view->getUserAgent())) {
			if ($remember) {
				$this->view->remember();
			}

			return true;
		} else {
			return false;
		}
	}

	public function index() {
		if ($this->view->didLogout()) {
			$this->model->logOut();
		}

		if ($this->view->didLogin()) {
			if ($this->validateLogin()) {
				return $this->view->loggedIn();
			}
		}

		if ($this->model->isLoggedIn($this->view->getUserAgent())) {
			return $this->view->loggedIn();
		}

		if ($this->view->getToken() != '') {
			$token = $this->view->getToken();
			
			if ($this->model->validateToken($token)) {
				return $this->view->loggedIn();
			}
		}

		return $this->view->login();
	}
}
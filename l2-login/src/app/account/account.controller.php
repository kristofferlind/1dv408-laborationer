<?php

class AccountController {

	private $model;
	private $view;

	public function __construct($model, $view) {
		$this->model = $model;
		$this->view = $view;
	}

	public function index() {
		//Check if user wants to log out
		if (isset($_GET['action']) && $_GET['action'] == 'logout') {
			// $this->view->redirect($_SERVER['PHP_SELF']);
			$this->model->logOut();
		//Check if user is logged in
		} elseif ($this->model->isLoggedIn()) {
			return $this->view->loggedIn();
		}

		if ($this->view->didLogin()) {
		// debug_print_backtrace($_COOKIE);
		// die();
			if ($this->model->validateLogin()) {
				return $this->view->loggedIn();
			} else {
				// $this->view->redirect($_SERVER['PHP_SELF']);
				return $this->view->login();
			}
		}


		return $this->view->login();
	}
}
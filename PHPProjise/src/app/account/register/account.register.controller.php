<?php

class AccountRegisterController extends BaseController {
	private $view;
	private $model;

	//Create account (register)
	private function tryRegister() {
		$notify = $this->model->notify;
		$username = $this->view->getUsername();
		$password = $this->view->getPassword();
		$confirmPassword = $this->view->getConfirmPassword();
		$userAgent = $this->view->getUserAgent();
		$correct = true;

		//Validation should be moved to model
		if ($password != $confirmPassword) {
			$notify->error('Passwords do not match.');
			$correct = false;
		}

		//Username should be at least 3 chars
		if (strlen($username) < 3) {
			$notify->error('Username is too short, should be atleast 3 characters.');
			$correct = false;
		}

		//Password should be atleast 6 chars
		if (strlen($password) < 6) {
			$notify->error('Password is too short, should be atleast 6 characters.');
			$correct = false;
		}

		//Username should have no illegal characters
		if (preg_match("/^[a-zA-Z0-9]+$/", $username) === 0 && strlen($username) != 0) {
			$notify->error('Username contains illegal characters ([a-zA-Z0-9] allowed).');
			$name = $username;
			$name = preg_replace("/[^a-zA-Z0-9]/i", "", $name);
			$name = filter_var($name, FILTER_SANITIZE_STRING);
			$this->view->setUsername($name);
			$correct = false;
		}


		if ($correct) {
			//Try to register user
			$registerStatus = $this->model->tryRegister($username, $password, $userAgent);

			if ($registerStatus === true) {
				$notify->success('User was successfully created.');
				$this->view->redirect('?section=account&page=index');
				return '';
			} else {
				$notify->error($registerStatus);
				$this->view->redirect('?section=account&page=register');
				return '';
			}
		} else {
			//Validation failed, reload register page
			$this->view->redirect('?section=account&page=register');
			return '';
		}
	}

	public function index() {
		$this->view = new AccountRegisterView();
		$this->model = new AccountRegisterModel();

		//Did user request account registration?
		if ($this->view->didRegister()) {
			//Try to register account
			$this->tryRegister();
		}

		//Show default view
		return $this->view->index();
	}
}
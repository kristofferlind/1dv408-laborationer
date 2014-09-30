<?php

class AccountRegisterController extends BaseController {
	private $view;
	private $model;

	private function tryRegister() {
		$notify = $this->model->notify;
		$username = $this->view->getUsername();
		$password = $this->view->getPassword();
		$confirmPassword = $this->view->getConfirmPassword();
		$userAgent = $this->view->getUserAgent();
		$correct = true;

		if ($password != $confirmPassword) {
			$notify->error('Passwords do not match.');
			$correct = false;
		}

		if (preg_match("/^[a-zA-Z0-9]+$/", $username) === 0 && strlen($username) != 0) {
			$notify->error('Username contains illegal characters ([a-zA-Z0-9] allowed).');
			$name = $username;
			$name = filter_var($name, FILTER_SANITIZE_STRING);
			$view->setUsername(preg_replace("/[^a-zA-Z0-9]/i", "", $name));
			$correct = false;
		}

		if (strlen($username) < 3) {
			$notify->error('Username is too short, should be atleast 3 characters.');
			$correct = false;
		}

		if (strlen($password) < 6) {
			$notify->error('Password is too short, should be atleast 6 characters.');
			$correct = false;
		}

		if ($correct) {
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
			$this->view->redirect('?section=account&page=register');
			return '';
		}
	}

	public function index() {
		$this->view = new AccountRegisterView();
		$this->model = new AccountRegisterModel();

		if ($this->view->didRegister()) {
			$this->tryRegister();
		}

		return $this->view->index();
	}
}
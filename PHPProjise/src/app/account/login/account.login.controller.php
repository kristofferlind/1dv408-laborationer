<?php

class AccountLoginController extends BaseController {
	private $view;
	private $model;
	
	private function validateLogin() {
		$username = $this->view->getUsername();
		$password = $this->view->getPassword();
		$remember = $this->view->getRemember();
		$userAgent = $this->view->getUserAgent();

		//Check if credentials are correct
		if ($this->model->validateCredentials($username, $password, $remember, $userAgent)) {
			//Should we remember user?
			if ($remember) {
				$this->view->remember();
			}

			return true;
		} else {
			return false;
		}
	}

	public function index() {
		$this->view = new AccountLoginView();
		$this->model = new AccountLoginModel();

		//Did user click login?
		if ($this->view->didLogin()) {

			//Validate credentials (post)
			if ($this->validateLogin()) {
				//User logged in, show projects 
				//(should show page requested when auth was needed and 
				//projects page if login was the referer)
				$this->view->redirect('?section=project&page=list');
				return '';
			} else {
				//Get rid of post request
				$this->view->redirect('?section=account&page=index');
				return '';
			}
		}


		return $this->view->index();
	}
}
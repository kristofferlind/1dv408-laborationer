<?php

//Routing for account pages
class AccountController extends BaseController {
	public function index() {
		switch ($this->page) {
			case 'index':		//Login page
				$controller = new AccountLoginController();
				return $controller->index();
			case 'register': 	//Register page
				$controller = new AccountRegisterController();
				return $controller->index();
		}

		$controller = new AccountLoginController();
		return $controller->index();
	}
}
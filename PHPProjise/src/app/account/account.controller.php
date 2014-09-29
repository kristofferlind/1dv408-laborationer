<?php

class AccountController extends BaseController {
	public function index() {
		switch ($this->page) {
			case 'index':
				$controller = new AccountLoginController();
				return $controller->index();
			case 'register':
				$controller = new AccountRegisterController();
				return $controller->index();
		}

		$controller = new AccountLoginController();
		return $controller->index();
	}
}
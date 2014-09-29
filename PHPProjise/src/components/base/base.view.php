<?php

class BaseView {
	public $cookieService;

	public function getPage() {
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 'index';
		}
		
		return $page;
	}

	public function getAction() {
		if (isset($_GET['action'])) {
			$action = $_GET['action'];
		} else {
			$action = 'index';
		}

		return $action;
	}

	public function __construct() {
		$this->cookieService = new CookieService();
	}
}
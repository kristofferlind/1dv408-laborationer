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

	public function getId() {
		if (isset($_GET['id'])) {
			return $_GET['id'];
		} else {
			return null;
		}
	}

	public function getSection() {
		if (isset($_GET['section'])) {
			$section = $_GET['section'];
		} else {
			$section = 'account';
		}

		return $section;
	}

	//Get token from cookie
	public function getToken() {
		if ($this->cookieService->loadToken() != '') {
			return $this->cookieService->loadToken();
		} else {
			return '';
		}
	}

	//Remove token, remove on fail
	public function removeToken() {
		$this->cookieService->remove('token');
	}

	public function __construct() {
		$this->cookieService = new CookieService();
	}

	//Redirect, to get rid of post
	public function redirect($location) {
		header('Location: ' . $location);
	}

	//Get client browser info
	public function getUserAgent() {
		return $_SERVER['HTTP_USER_AGENT'];
	}
}
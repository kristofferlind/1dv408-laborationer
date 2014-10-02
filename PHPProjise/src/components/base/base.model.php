<?php

class BaseModel {
	public $notify;
	
	public function getActiveProject() {
		if (isset($_SESSION['user'])) {
			$user = $_SESSION['user'];
			return $user->activeProject;
		} else {
			return '';
		}
	}

	public function logout() {
		session_destroy();
		session_start();
		$this->notify->info('You are now logged out.');
	}

	public function __construct() {
		$this->notify = new Notify();
	}
}
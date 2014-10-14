<?php

class BaseModel {
	public $notify;
	protected $user;
	
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

	public function setUser(User $user) {
		$_SESSION['user'] = $user;
		$this->user=$_SESSION['user'];
	}

	public function __construct() {
		$this->notify = new Notify();
		if (isset($_SESSION['user'])) {
			$this->user = $_SESSION['user'];
		} else {
			$_SESSION['user'] = '';
			$this->user = $_SESSION['user'];
		}
	}
}
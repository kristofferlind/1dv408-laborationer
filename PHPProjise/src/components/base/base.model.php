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

	public function __construct() {
		$this->notify = new Notify();
	}
}
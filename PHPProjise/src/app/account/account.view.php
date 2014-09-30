<?php

class AccountView extends BaseView {

	//Get username from post
	public function getUsername() {
		if (isset($_POST['username'])) {
			//Save username in cookie to remember input
			$this->cookieService->save('username', $_POST['username']);
			return $_POST['username'];
		} else {
			return $this->cookieService->load('username');
		}
		
		return '';
	}

	//Get password from post
	public function getPassword() {
		if (isset($_POST['password']) && $_POST['password'] != '') {
			return $_POST['password'];
		}

		return '';
	}
}

<?php

class AccountView extends BaseView {

	//Get username from post
	public function getUsername() {
		if (isset($_POST['username'])) {

			//Hack, couldn't figure out where this was called last, so this check in controller didn't work
			$username = $_POST['username'];
			$username = preg_replace("/[^a-zA-Z0-9]/i", "", $username);
			$username = filter_var($username, FILTER_SANITIZE_STRING);

			//Save username in cookie to remember input			
			$this->cookieService->save('username', $username);
			return $_POST['username'];
		} else {
			return htmlspecialchars($this->cookieService->load('username'));
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

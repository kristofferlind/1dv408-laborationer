<?php

class AccountLoginView extends AccountView {
	private $model;
	// public $cookieService;

	//Remember user?
	public function getRemember() {
		if (isset($_POST['remember'])) {
			return $_POST['remember'];
		} else {
			return false;
		}
	}

	//Remember user, sets cookie with token and expiration
	public function remember() {
		$token = $this->model->token;
		$expiration = $this->model->tokenExpiration;
		$this->cookieService->saveToken($token, $expiration);
	}

	//Get token from cookie
	public function getToken() {
		if ($this->cookieService->loadToken() != '') {
			return $this->cookieService->loadToken();
		} else {
			return '';
		}
	}
	//Get client browser info
	public function getUserAgent() {
		return $_SERVER['HTTP_USER_AGENT'];
	}

	//Did user request login?
	public function didLogin() {
		if (isset($_POST['login'])) {
			return true;
		} else {
			return false;
		}
	}

	public function index() {
		$username = $this->getUsername();
		return "
				<div class='backdrop'>
					<section class='form-signin'>
					    <form action='?section=account&page=index' role='form' method='post'>
		        			<h2 class='form-signin-heading'>Please sign in</h2>
		        			<input value='$username' type='text' name='username' class='form-control' placeholder='Username' required autofocus>
				        	<input type='password' name='password' class='form-control' placeholder='Password' required>
				        	<label class='checkbox' name='remember'>
				          		<input type='checkbox' value='remember-me'> Remember me
				        	</label>
				        	<button name='login' class='btn btn-lg btn-primary btn-block' type='submit'>Sign in</button>
				        	Don't have an account? <a href='?section=account&page=register'>Register</a>.
				      	</form>
			      	</section>
		      	</div>";
	}
}
<?php

class AccountRegisterView extends AccountView {
	//Does user want to register an account?
	public function didRegister() {
		if (isset($_POST['register'])) {
			return true;
		} else {
			return false;
		}
	}

	//Get the confirm password from registration form
	public function getConfirmPassword() {
		if (isset($_POST['confirmPassword'])) {
			return $_POST['confirmPassword'];
		}

		return '';
	}

	//Remember username in case form is shown again
	public function setUsername($username) {
		$this->cookieService->save('username', $username);
	}

	public function index() {
		$username = $this->getUsername();
		return "
				<div class='backdrop'>
					<section class='form-signin'>
					    <form role='form' method='post'>
		        			<h2 class='form-signin-heading'>Register</h2>
		        			<input value='$username' type='text' name='username' class='form-control' placeholder='Username' required autofocus>
				        	<input type='password' name='confirmPassword' class='form-control' placeholder='Password' required>
				        	<input type='password' name='password' class='form-control' placeholder='Confirm password' required>
				        	<label class='checkbox' name='remember'>
				          		<input type='checkbox' value='remember-me'> Remember me
				        	</label>
				        	<button name='register' class='btn btn-lg btn-primary btn-block' type='submit'>Sign up</button>
				        	Already have an account? <a href='?section=account&page=index'>Log in</a>.
				      	</form>
			      	</section>
		      	</div>";
	}
}
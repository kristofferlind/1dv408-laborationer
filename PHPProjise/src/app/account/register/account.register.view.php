<?php

class AccountRegisterView extends AccountView {
	public function didRegister() {
		if (isset($_POST['register'])) {
			return true;
		} else {
			return false;
		}
	}

	public function getConfirmPassword() {
		if (isset($_POST['confirmPassword'])) {
			return $_POST['confirmPassword'];
		}

		return '';
	}

	public function setUsername($username) {
		$this->cookieService->save('username', $username);
	}

	public function index() {
		return "
				<div class='backdrop'>
					<section class='form-signin'>
					    <form role='form' method='post'>
		        			<h2 class='form-signin-heading'>Register</h2>
		        			<input type='text' name='username' class='form-control' placeholder='Username' required autofocus>
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
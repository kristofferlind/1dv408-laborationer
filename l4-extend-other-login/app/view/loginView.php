<?php

namespace View;

require_once(realpath(dirname(__FILE__)."/../model/loginModel.php"));

class LoginView{
	private $model = null;
	private $title;
	private $flashMessage = 'no message';
	private $postToken_Name = "name"; // $_POST['name']
	private $postToken_PW = "pw"; // $_POST['name']
	private $getToken_logout = "logout"; // $_POST['name']
	private $getToken_keepSession = "keep_session";
	private $cookie_LoginCookie = "LoginCookie";
	private $lastUsername = "";

	// check if enough info has been suported to the page
	private function validateForm(){

		// extra precaution, should not happen if form hasnt been manipulated
		if( isset($_POST[$this->postToken_Name]) == false || isset($_POST[$this->postToken_PW]) == false){
			$this->setFlashText = "Formulär saknar delar";
			return false;
		}
		
		if( $_POST[$this->postToken_Name] === ""){
			$this->setFlashText("Användarnamn saknas");
			return false;
		}

		$this->lastUsername = $_POST[$this->postToken_Name];

		if( $_POST[$this->postToken_PW] === ""){
			$this->setFlashText("Lösenord saknas");
			return false;
		}

		return true;
	}

	// user has sent credentials to /login
	public function userIsTryingToLogin(){

		// there seems to be a submitted form, now validate it.
		if( isset($_POST[$this->postToken_Name]) )
			return $this->validateForm();

		return false;
	}

	public function userIsTryingToLogout(){
		if( isset($_GET[$this->getToken_logout]) ){
			setcookie ($this->cookie_LoginCookie, "", time() - 3600); 
			return true;
		}

		return false;
	}

	public function userWantToStayLogedIn(){
		if( isset($_POST[$this->getToken_keepSession]) )
			return true;

		return false;
	}

	public function setLoginCookie($offlineIdentyfierString){
		setcookie($this->cookie_LoginCookie, $offlineIdentyfierString, time()+3600);  /* expire in 1 hour */
	}

	// check if there is a cookie we can use for login
	public function getLoginIdentyfierFromCookie(){
		if( isset($_COOKIE[$this->cookie_LoginCookie]) ) return $_COOKIE[$this->cookie_LoginCookie];
		return false;
	}

	public function setFlashText($msg){
		$this->flashMessage = $msg;
	}

	public function getBrowserDesc(){
		return $_SERVER['HTTP_USER_AGENT'];
	}

	// used by POST form login
	public function getCredentials(){
		$creds = array();
		$creds['name'] = $_POST[$this->postToken_Name];
		$creds['pw'] = $_POST[$this->postToken_PW];
		$creds['browser'] = $this->getBrowserDesc();
		return $creds;
	}

	// used by Cookie login
	public function getCookieLoginCredentials(){
		$creds = array();
		$creds['identyfier'] = $_COOKIE[$this->cookie_LoginCookie];
		$creds['browser'] = $this->getBrowserDesc();
		return $creds;
	}

	public function reloadPage($getValue){
		header("Location: $getValue"); // same location
		die();
	}

	public function __construct($inModel) {
		$this->model = $inModel;
		$this->title = "Laboration, inte inloggad";
		$this->setFlashText("");
	}

	public function makeLoginForm($currentUser){
		//$textFromFlash = $this->model->pullFromFlash(); // from session variable
		$form = "<form method='post' action='?login'>
				<div>
				<fieldset><legend>Login - skriv användarnamn och lösenord </legend>
					<div>$this->flashMessage</div>
					<label for='name'>Namn</label>
					<input type='text' name='name' placeholder='namn' value='$this->lastUsername'/>

					<label for='pw'>Password</label>
					<input type='text' name='pw' placeholder='***' value=''/>

					<label for='keep_session'>Håll mig inloggad</label>
					<input type='checkbox' name='keep_session' value='your_value'>

					<input type='submit' value='Logga in'>
				</fieldset>
				</div>
				</form>";

		if($currentUser !== null) $form = ""; // no login-form if there is a loged in user

		return $form;
	}

	public function displayTheLink($currentUser){
		if($currentUser == null) {
			$html = "
				<div><a href='?create'>registrera ny användare</a></div><br />
			";
		} else {
			$html = "
				<div><a href='?logout'>Logga ut</a></div><br />
			";
		}
		return $html;
	}

	public function displayLoginStatusText($currentUser){
		$textFromFlash = $this->model->pullFromFlash(); // from session variable

		if($currentUser == null) {
			$html = "
				<div><h2>Ej inloggad</h2></div>
			";
		} else {
			$html = "
				<h2>$currentUser->name är inloggad</h2>
				<p>$textFromFlash</p>
			";
		}
		return $html;
	}

	private function displayTime(){
		date_default_timezone_set("Europe/Stockholm");
		setlocale(LC_TIME,"swedish");
	
		// first letter as caption
		$weekDay = utf8_encode(ucfirst(strftime("%A")));
		$month = utf8_encode(ucfirst(strftime("%B")));

		return strftime("<p>$weekDay den %#d $month år %Y. Klockan är [%H:%M:%S]</p>");
	}

	private function generateFlashMessage()
	{
		if( $this->userIsTryingToLogout() )
			$this->setFlashText("Du har nu loggat ut.");
	}

	public function renderView(){
		$viewHTML = "<!doctype html>
			<html>
				<head>
					<meta charset='UTF-8'>
					<title>$this->title</title>
				</head>
			<body>
				<h1>Labborationskod kg222dy</h1>";

		$currentUser = $this->model->getCurrentUser($this->getBrowserDesc());
		$this->generateFlashMessage();

		$viewHTML .= $this->displayLoginStatusText($currentUser);
		$viewHTML .= $this->displayTheLink($currentUser);
		$viewHTML .= $this->makeLoginForm($currentUser);
		$viewHTML .= $this->displayTime();
		$viewHTML .= '</body></html>';

		return $viewHTML;
	}
}
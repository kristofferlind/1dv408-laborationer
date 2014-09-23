<?php

require_once(realpath(dirname(__FILE__)."/../view/loginView.php"));


class LoginCtrl{

	private $model = null;
	//private $loginView = null;

	public function __construct($inModel) {
		$this->model = $inModel;
	}

	private function doLoginAttempt($view){
		$crendetials = $view->getCredentials();

		if($this->model->tryLoginCurrentUser($crendetials) == true){
			$this->model->putInFlash("Inloggingen lyckades"); // this will be shown after page is reloaded
			
			if($view->userWantToStayLogedIn()){
				$expireTime = time()+(60); // will be valid for 60sec
				$offlineIdentyfierString = $this->model->setOfflineIdentyfier($expireTime);
				$view->setLoginCookie($offlineIdentyfierString);
				$this->model->putInFlash('Inloggingen lyckades och vi kommer ihåg dig nästa gång. (60 sec)');
			}

			$view->reloadPage("?login");
			return true;
		} else {
			$view->setFlashText('Felaktigt användarnamn och/eller lösenord.');
		}

		return false;
	}

	private function doLoginAttemptFromStoredIdentifyer($view){
		//$view->setLoginCookie("corrupt");
		$crendetials = $view->getCookieLoginCredentials();

		if($this->model->tryLoginCurrentWithIdentyfier($crendetials)){
			$this->model->putInFlash("Inloggingen lyckades via cookies"); // this will be shown after page is reloaded

			$view->reloadPage("?login");
		} else {
			$view->setFlashText('Felaktigt information i cookie');
			$view->removeIdentifier();
		}
	}

	public function doRegisterAttempt($view) {
		$register = $view->getRegisterData();
		$correct = true;
		$notify = $this->model->notify;

		if (!$register) {
			return $view->registerView();
		}

		if ($register['pw'] != $register['pw2']) {
			$notify->error('Lösenorden matchar inte');
			$correct = false;
		}

		if (preg_match("/^[a-zA-Z0-9]+$/", $register['name']) === 0 && strlen($register['name']) != 0) {
			$notify->error('Användarnamnet innehåller ogiltiga tecken.');
			$name = $register['name'];
			$name = filter_var($name, FILTER_SANITIZE_STRING);
			$view->lastUsername = preg_replace("/[^a-zA-Z0-9]/i", "", $name);
			$correct = false;
		}

		if (strlen($register['name']) < 3) {
			$notify->error('Användarnamnet har för få tecken. Minst 3 tecken.');
			$correct = false;
		}

		if (strlen($register['pw']) < 6) {
			$notify->error('Lösenordet har för få tecken. Minst 6 tecken.');
			$correct = false;
		}

		if ($correct) {
			$registerStatus = $this->model->register($register);
			if ($registerStatus !== true) {
				$notify->error($registerStatus);
			} else {
				$notify->success('Registrering av ny användare lyckades.');
				return $view->renderView();
			}
		}

		return $view->registerView();
	}

	public function doControll(){

		$view = new LoginView($this->model);
		$authenticated = false;

		if ($view->didRegister()) {
			return $this->doRegisterAttempt($view);
		}

		if ($view->wantsToRegister()) {
			return $view->registerView();
		}

		// there is a current user for this browser ==> user is already loged in 
		if($this->model->getCurrentUser($view->getBrowserDesc()) !== null ) {
			$authenticated = true;
		}

		if( $view->userIsTryingToLogout() ){
			$this->model->doLogout();
			return $view->renderView();
		}

		if( $view->userIsTryingToLogin() ){
			$authenticated = $this->doLoginAttempt($view);
		}

		if($authenticated == false && $view->getLoginIdentyfierFromCookie() ){
			$this->doLoginAttemptFromStoredIdentifyer($view);
		}

		return $view->renderView();
	}
}
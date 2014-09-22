<?php

namespace Controller;

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
		}
	}

	public function doControll(){

		$view = new \View\LoginView($this->model);
		$authenticated = false;

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
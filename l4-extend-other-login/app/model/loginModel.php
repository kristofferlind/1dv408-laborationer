<?php

namespace Model;

require_once(realpath(dirname(__FILE__)."/sessionObjects.php" ));
require_once(realpath(dirname(__FILE__)."/userDAL.php" ));
require_once(realpath(dirname(__FILE__)."/offlineIdentyfierDAL.php" ));
require_once(realpath(dirname(__FILE__)."/sessionService.php" ));

class LoginModel{
	private $usersDAL;
	private $offlineIdentyfierDAL;
	private $sessionService;
	const session_currUser = 'LoginModel::current_user';
	const session_flash = 'LoginModel::flash_memory';

	/**
	*  Desc: Current user is an object stored as a seesion variable. It 
	*  @param $browserDesc. string or null. It is used used to filter away users with non matching browser info.
	*  returns: currentUser an object of class CurrentUser or null  
	**/
	public function getCurrentUser($browserDesc = null){
		$currUser = $this->sessionService->getObject(LoginModel::session_currUser);

		if($currUser == null) return null;

		// check if the browserDesc does not match the brewser-description for the current used 
		if($browserDesc !== null){
			if($currUser->browser !== $browserDesc)
				return null;
		}

		return $currUser; // just return what we got as current used
	}

	public function doLogout(){
		$this->sessionService->remove(LoginModel::session_currUser);
	}

	public function putInFlash($flashMsg){
		$this->sessionService->setValue(LoginModel::session_flash, $flashMsg);
	}

	public function pullFromFlash(){
		$value = $this->sessionService->getValue(LoginModel::session_flash);
		$this->sessionService->remove(LoginModel::session_flash);
		return $value;
	}

	public function setOfflineIdentyfier($expireTime){
		$currUser = $this->getCurrentUser();

		$IdentyfierString = $this->offlineIdentyfierDAL->setIdentyfierForUser($currUser, $expireTime);
		return $IdentyfierString;
	}

	/* desc: will pull out a User with matching name from db and put it as a session-variable if it was
	* found to be ok. 
	* @param: $arrCreds : array
	**/
	public function tryLoginCurrentUser($arrCreds){
		$foundUser = $this->usersDAL->retrieveUserByName($arrCreds['name']);

		if($foundUser === null) return false; // no user with that name
		if( $foundUser->pw !== $arrCreds['pw']) return false; // maybe the pw check should be done in db-query

		// convert data from DAL to a current usert to be put as a session variable
		$currUser = new CurrentUser($arrCreds['name'], $foundUser->id, $arrCreds['browser']);

		$this->sessionService->setObject(LoginModel::session_currUser, $currUser);

		return true;
	}

	/* desc: will pull out a User with matching name from db and put it as a session-variable if it was
	* found to be ok. 
	* @param: $arrCreds : array
	**/
	public function tryLoginCurrentWithIdentyfier($arrCreds){

		$foundUser = $this->offlineIdentyfierDAL->getUserFromIdentyfier($arrCreds['identyfier'], $arrCreds['browser']);

		if($foundUser === null) return false; // no user with that name
		if($foundUser->expire < time()) return false;


		// convert data from DAL to a current usert to be put as a session variable
		$currUser = new CurrentUser($foundUser->name, $foundUser->id, $arrCreds['browser']);

		$this->sessionService->setObject(LoginModel::session_currUser, $currUser);

		return true;
	}

	public function __construct($sessionService, $usersDAL, $offlineIdentyfierDAL) {
		$this->offlineIdentyfierDAL = $offlineIdentyfierDAL;
		$this->usersDAL = $usersDAL;//  = new UserDAL($filePath);
		$this->sessionService = $sessionService; //new SessionService();
	}
}
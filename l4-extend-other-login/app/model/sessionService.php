<?php

session_start(); 

class SessionService{
	
	public function setValue($key, $value){
		$_SESSION[$key] = $value;
	}

	public function getValue($key){
		if (isset($_SESSION[$key])) return $_SESSION[$key];
	}

	public function setObject($key, $obj){
		$_SESSION[$key] = serialize($obj);
	}

	public function getObject($key){

		if(isset($_SESSION[$key])) {
			return unserialize($_SESSION[$key]);
		} 

		return null;
	}

	public function remove($key){
		unset($_SESSION[$key]);
	}
}
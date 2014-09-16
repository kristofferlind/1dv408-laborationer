<?php

//Save token and save could use the same function with optional expiration
class CookieService {
	private static $cookieName = "CookieService";

	//Saves token
	public function saveToken($token, $expiration) {
		$_COOKIE[self::$cookieName . '::token'] = $token;
		setcookie( self::$cookieName . '::token', $token, $expiration);
	}

	//Save cookie
	public function save($name, $string) {
		$_COOKIE[self::$cookieName . '::' . $name] = $string;
		setcookie( self::$cookieName . '::' . $name, $string, time()+(60*60*24*30));
	}

	//Load cookie
	public function load($name) {
		if (isset($_COOKIE[self::$cookieName . '::' . $name])) {
			$ret = $_COOKIE[self::$cookieName . '::' . $name];
		}
		else {
			$ret = '';
		}

		// $this->remove($name);

		return $ret;
	}

	//Remove cookie, dead code?
	public function remove($name) {
		$_COOKIE[self::$cookieName . '::' . $name] = '';
		setcookie(self::$cookieName . '::' . $name, '', time()-1);
	}
}
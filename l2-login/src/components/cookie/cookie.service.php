<?php

class CookieService {
	private static $cookieName = "CookieService";

	public function saveToken($token, $expiration) {
		$_COOKIE[self::$cookieName . '::token'] = $token;
		setcookie( self::$cookieName . '::token', $token, $expiration);
	}

	public function save($name, $string) {
		$_COOKIE[self::$cookieName . '::' . $name] = $string;
		setcookie( self::$cookieName . '::' . $name, $string, time()+(60*60*24*30));
	}

	public function load($name) {
		if (isset($_COOKIE[self::$cookieName . '::' . $name])) {
			$ret = $_COOKIE[self::$cookieName . '::' . $name];
		}
		else {
			$ret = '';
		}

		return $ret;
	}

	public function remove($name) {
		$_COOKIE[self::$cookieName . '::' . $name] = '';
		setcookie(self::$cookieName . '::' . $name, '', time()-1);
	}
}
<?php

class CookieService {
	private static $cookieName = "CookieService";

	public function save($string) {
		$_COOKIE[self::$cookieName] = $string;
		setcookie( self::$cookieName, $string, time()+6000000);
	}

	public function load() {
		if (isset($_COOKIE[self::$cookieName])) {
			$ret = $_COOKIE[self::$cookieName];
		}
		else {
			$ret = "";
		}

		setcookie(self::$cookieName, "", time() -1);

		// debug_print_backtrace();
		return $ret;
	}
}
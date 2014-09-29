<?php

class AccountDAL extends BaseDAL {

	public function retrieveUserByCredentials($username, $password) {
		$db = $this->connection();
		var_dump($db);
		var_dump(get_class_methods($db));
		$sql = 'SELECT * FROM users WHERE username = :username AND password = :password';
		$params = array(':username' => $username, ':password' => $password);
		$query = $db->prepare($sql);
		$query->execute($params);
		$user = $query->fetchObject();

		if ($user === false) {
			return null;
		}

		return $user;
	}
}
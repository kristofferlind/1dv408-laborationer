<?php

abstract class BaseDAL {
	protected $connection;
	private $connectionString;

	public function __construct() {
		$host = Settings::$host;
		$database = Settings::$database;
		$this->connectionString = "mysql:host=$host;dbname=$database";
	}

	protected function connection() {
		if ($this->connection === null) {
			try {
				$this->connection = new PDO($this->connectionString, Settings::$username, Settings::$password);
				$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				die($e);
			}
		}
		return $this->connection;
	}
}
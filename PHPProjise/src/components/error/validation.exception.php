<?php

class ValidationException extends Exception {
	public $errors;

	public function __construct($errors) {
		$this->errors = $errors;
	}
}

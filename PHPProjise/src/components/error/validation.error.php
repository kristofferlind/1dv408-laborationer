<?php

class ValidationError {
	public $name;
	public $description;

	public function __construct($description, $name = 'Failure!') {
		$this->name = $name;
		$this->description = $description;
	}
}
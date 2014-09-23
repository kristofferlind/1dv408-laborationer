<?php

// an object ment to store info about the loged in user
class CurrentUser{
	public $name;
	public $browser;
	public $id;

	public function __construct($name, $id, $browser){
		$this->name = $name;
		$this->browser = $browser;
		$this->id = $id;
	}
}
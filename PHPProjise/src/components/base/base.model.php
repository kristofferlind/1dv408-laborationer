<?php

class BaseModel {
	public $notify;

	public function __construct() {
		$this->notify = new Notify();
	}
}
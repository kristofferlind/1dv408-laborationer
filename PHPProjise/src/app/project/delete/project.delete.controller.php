<?php

class ProjectDeleteController extends AuthenticationController {
	private $view;
	public function index() {
		$this->view = new ProjectDeleteView();

		return $this->view->index();
	}
}
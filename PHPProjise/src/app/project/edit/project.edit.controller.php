<?php

class ProjectEditController extends AuthenticationController {
	private $view;
	public function index() {
		$this->view = new ProjectEditView();

		return $this->view->index();
	}
}
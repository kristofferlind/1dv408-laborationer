<?php

class ProjectCreateController extends AuthenticationController {
	private $view;
	public function index() {
		$this->view = new ProjectCreateView();

		return $this->view->index();
	}
}
<?php

class ProjectListController extends AuthenticationController {
	private $view;
	public function index() {
		$this->view = new ProjectListView();

		return $this->view->index();
	}
}
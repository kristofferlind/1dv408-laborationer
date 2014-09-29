<?php

class ProjectController extends AuthenticationController {
	public function index() {
		switch ($this->page) {
			case 'index':
				$controller = new ProjectListController();
				return $controller->index();
			case 'create':
				$controller = new ProjectCreateController();
				return $controller->index();
			case 'edit':
				$controller = new ProjectEditController();
				return $controller->index();
			case 'delete':
				$controller = new ProjectDeleteController();
				return $controller->index();
		}

		$controller = new ProjectListController();
		return $controller->index();
	}
}
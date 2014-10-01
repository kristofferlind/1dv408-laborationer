<?php

class StoryController extends AuthenticationController {
	private $projectModel;

	public function __construct() {
		parent::__construct();
		$this->projectModel = new ProjectModel();

	}

	public function index() {
		$view = new BaseView();
		$activeProject = $this->projectModel->getActiveProject();
		if ($activeProject) {
			$this->activeProject = $activeProject;
		} else {
			$this->projectModel->notify->error('You need to have an active project to view stories.');
			$view->redirect('?section=project&page=index');
			return '';
		}
		switch ($this->page) {
			case 'index':
				$controller = new StoryListController();
				return $controller->index();
			case 'create':
				$controller = new StoryCreateController();
				return $controller->index();
			case 'edit':
				$controller = new StoryEditController();
				return $controller->index();
			case 'delete':
				$controller = new StoryDeleteController();
				return $controller->index();
		}

		$controller = new StoryListController();
		return $controller->index();
	}
}
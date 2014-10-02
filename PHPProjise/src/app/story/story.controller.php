<?php

class StoryController extends AuthenticationController {
	private $projectModel;

	public function __construct() {
		parent::__construct();
		$this->projectModel = new ProjectModel();
	}

	//Acts as router for story pages (a bit unnecessary since there's only 2 routes now.. planned on 4)
	public function index() {
		$view = new BaseView();
		$activeProject = $this->projectModel->getActiveProject();
		//Make sure user has an active project
		if ($activeProject) {
			$this->activeProject = $activeProject;
		} else {
			//Otherwise send user to projects
			$this->projectModel->notify->info('You need to have an active project to view stories.');
			$view->redirect('?section=project&page=index');
			return '';
		}
		switch ($this->page) {
			case 'index':
				$controller = new StoryListController();
				return $controller->index();
			case 'edit':
				$controller = new StoryEditController();
				return $controller->index();
		}

		$controller = new StoryListController();
		return $controller->index();
	}
}
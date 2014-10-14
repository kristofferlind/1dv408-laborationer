<?php

class ProjectEditController extends AuthenticationController {
	private $view;
	private $model;

	public function index() {
		$this->view = new ProjectEditView();
		$this->model = new ProjectModel();

		$projectId = $this->view->getId();

		$project = $this->model->getProject($projectId);

		//Does user want to update?
		if ($this->view->didUpdate()) {
			$successUrl = '?section=project&page=list';
			$failUrl = "?section=project&page=edit&id=$projectId";
			$inputProject = $this->view->getEditProjectFormData();
			$project = $this->objectCreator($inputProject, 'Project');
			if ($this->isValid($project)) {
				$project->projectId = $projectId;

				$isUpdated = $this->model->updateProject($project);

				//Was project updated
				if ($isUpdated) {
					// if it was, show project
					$this->view->redirect($successUrl);
				} else {
					$this->view->redirect($failUrl);
				}				
			} else {
				$this->view->redirect($failUrl);
			}
		}
		return $this->view->index($project);
	}
}
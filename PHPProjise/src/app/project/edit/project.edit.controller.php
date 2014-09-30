<?php

class ProjectEditController extends AuthenticationController {
	private $view;
	private $model;

	public function index() {
		$this->view = new ProjectEditView();
		$this->model = new ProjectModel();

		$projectId = $this->view->getId();

		$project = $this->model->getProject($projectId);

		if ($this->view->didUpdate()) {
			$updateProject = $this->view->getEditProjectFormData();
			$updateProject['projectId'] = $projectId;
			$isUpdated = $this->model->updateProject($updateProject);
			if ($isUpdated) {
				//redirect to list
			}
		}


		return $this->view->index($project);
	}
}
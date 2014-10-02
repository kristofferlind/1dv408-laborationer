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
			$updateProject = $this->view->getEditProjectFormData();
			$updateProject['projectId'] = $projectId;
			$isUpdated = $this->model->updateProject($updateProject);

			//Was project updated
			if ($isUpdated) {
				// if it was, show project
				$this->view->redirect('?section=project&page=list');
			} else {
				$this->view->redirect("?section=project&page=edit&id=$projectId");
			}
		}


		return $this->view->index($project);
	}
}
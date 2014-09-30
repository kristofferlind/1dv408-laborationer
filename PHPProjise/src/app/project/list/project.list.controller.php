<?php

class ProjectListController extends AuthenticationController {
	private $view;
	private $model;
	public function index() {
		$this->view = new ProjectListView();
		$this->model = new ProjectModel();
		$action = $this->action;
		$id = $this->id;

		if ($action === 'delete') {
			$isDeleted = $this->model->deleteProject($id);
			$this->view->redirect('?section=project&page=index');
		}

		// if ($action === 'edit') {
		// 	$this->view->redirect('?section=project&page=edit&id=$id');
		// 	return '';
		// }

		if ($this->view->didCreate()) {
			$createData = $this->view->getCreateFormData();
			$isCreated = $this->model->createProject($createData);
			if (!$isCreated) {
				//show create view with errors and remembered values?
				//or just present that it failed?
				//might also remember data in this form
			}
		}

		$projects = $this->model->getProjects();

		return $this->view->index($projects);
	}
}
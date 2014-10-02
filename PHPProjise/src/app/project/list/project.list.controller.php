<?php

class ProjectListController extends AuthenticationController {
	private $view;
	private $model;
	public function index() {
		$this->view = new ProjectListView();
		$this->model = new ProjectModel();
		$action = $this->action;
		$id = $this->id;

		// A bit of a hack, this should be in account->logout
		// But cannot be placed there because of redirect (to not show login page to logged in users)
		// Could move the redirect to only be for the actual login page instead of any logged out page..
		// This would also be necessary if any public pages are added
		if ($action === 'logout') {
			$this->view->removeToken();
			$this->model->logout();
			// return '';
			$this->view->redirect('?section=account&page=index');
			return '';
			// die();
		}

		if ($action === 'delete') {
			$isDeleted = $this->model->deleteProject($id);
			$this->view->redirect('?section=project&page=index');
		}

		if ($action === 'activate') {
			$this->model->activateProject($id);
		}

		// if ($action === 'edit') {
		// 	$this->view->redirect('?section=project&page=edit&id=$id');
		// 	return '';
		// }

		if ($this->view->didCreate()) {
			$createData = $this->view->getCreateFormData();
			$isCreated = $this->model->createProject($createData);
			$this->view->redirect('?section=project&page=index');
			if (!$isCreated) {
				//show create view with errors and remembered values?
				//or just present that it failed?
				//might also remember data in this form
			}
			return '';
		}

		$projects = $this->model->getProjects();

		return $this->view->index($projects, $this->model);
	}
}
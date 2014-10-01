<?php

class StoryListController extends AuthenticationController {
	private $view;
	private $model;
	public function index() {
		$this->view = new StoryListView();
		$this->model = new StoryModel();
		$projectModel = new ProjectModel();
		$action = $this->action;
		$projectId = $projectModel->getActiveProject();
		$id = $this->view->getId();

		if ($action === 'delete') {
			$isDeleted = $this->model->deleteStory($id);
			$this->view->redirect('?section=story&page=index');
		}

		if ($action === 'edit') {
			$this->view->redirect('?section=story&page=edit&id=$id');
			return '';
		}

		if ($action === 'work') {
			$this->model->setStatus($projectId, $id, 2);
		}
		if ($action === 'cancel') {
			$this->model->setStatus($projectId, $id, 1);
		}
		if ($action === 'finish') {
			$this->model->setStatus($projectId, $id, 3);
		}

		if ($this->view->didCreate()) {
			$createData = $this->view->getCreateFormData();
			$isCreated = $this->model->createStory($createData);
			if (!$isCreated) {
				//show create view with errors and remembered values?
				//or just present that it failed?
				//might also remember data in this form
			}
		}

		$stories = $this->model->getStories($projectId);
		$categorized = $this->model->categorizeStories($stories);

		return $this->view->index($categorized);
	}
}
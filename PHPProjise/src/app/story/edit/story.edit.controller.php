<?php

class StoryEditController extends AuthenticationController {
	private $view;
	private $model;

	public function index() {
		$this->view = new StoryEditView();
		$this->model = new StoryModel();

		$storyId = $this->view->getId();

		$story = $this->model->getStory($storyId);

		if ($this->view->didUpdate()) {
			$updateStory = $this->view->getEditStoryFormData();
			$updateStory['storyId'] = $storyId;
			$isUpdated = $this->model->updateStory($updateStory);
			if ($isUpdated) {
				$this->view->redirect('?section=story&page=list');
			} else {
				$this->view->redirect("?section=story&page=edit&id=$storyId");
			}
		}


		return $this->view->index($story);
	}
}
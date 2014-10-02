<?php

class StoryEditController extends AuthenticationController {
	private $view;
	private $model;

	public function index() {
		$this->view = new StoryEditView();
		$this->model = new StoryModel();

		$storyId = $this->view->getId();

		$story = $this->model->getStory($storyId);

		//Does user want to update story?
		if ($this->view->didUpdate()) {
			//Get form data
			$updateStory = $this->view->getEditStoryFormData();
			$updateStory['storyId'] = $storyId;
			$isUpdated = $this->model->updateStory($updateStory);
			//Was update successful?
			if ($isUpdated) {
				$this->view->redirect('?section=story&page=index');
			} else {
				$this->view->redirect("?section=story&page=edit&id=$storyId");
			}
		}


		return $this->view->index($story);
	}
}
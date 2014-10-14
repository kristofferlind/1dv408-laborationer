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
			$story = $this->objectCreator($updateStory, 'Story');
			$isValid = $this->isValid($story);

			if ($isValid) {
				$story->storyId = $storyId;
				$isUpdated = $this->model->updateStory($story);
				//Was update successful?
				if ($isUpdated) {
					$this->view->redirect('?section=story&page=index');
					return '';
				}
			}
			$this->view->redirect("?section=story&page=edit&id=$storyId");
			return '';
		}

		return $this->view->index($story);
	}
}
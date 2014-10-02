<?php

class StoryModel extends BaseModel {
	private $storyDAL;

	//Fetch stories for project
	public function getStories($projectId) {
		//Make sure user is part of requested project
		if (!$this->checkUserIsPartOfProject($projectId)) {
			return false;
		}

		$stories = $this->storyDAL->getStories($projectId);

		//No stories?
		if (!$stories) {
			$this->notify->info('No stories found, go ahead and create one.');
			return false;
		}

		return $stories;
	}

	//Categorizes stories based on status (again.. should use enum)
	public function categorizeStories($stories) {
		if (!$stories) {
			return '';
		}

		$categorized = array();
		$categorized['notDone'] = array();
		$categorized['inProgress'] = array();
		$categorized['done'] = array();

		foreach ($stories as $story) {
			switch ($story->storyStatusId) {
				case 1:
					array_push($categorized['notDone'], $story);
					break;
				case 2:
					array_push($categorized['inProgress'], $story);
					break;
				case 3:
					array_push($categorized['done'], $story);
					break;
			}
		}

		return $categorized;
	}

	//Create story
	public function createStory($storyData) {
		$projectId = $_SESSION['user']->activeProject;
		//Make sure user is part of project
		if (!$this->checkUserIsPartOfProject($projectId)) {
			return false;
		}

		$story = new Story($storyData);

		//Validate
		if (!$this->validateStory($story)) {
			return false;
		}
		$isCreated = $this->storyDAL->createStory($story, $projectId);

		//Did creation fail?
		if (!$isCreated) {
			$this->notify->error('Could not create story, please try again.');
			return false;
		}

		//Successfully created story
		return true;
	}

	//Checks if user is part of requested project
	//Should really not be here..
	private function checkUserIsPartOfProject($projectId) {
		$user = $_SESSION['user'];
		$isPartOf = $this->projectDAL->checkUserIsPartOfProject($user->userId, $projectId);

		//Is user not part of project?
		if (!$isPartOf) {
			$this->notify->error('You cannot view stories of a project you are not a member of.');
			return false;
		}
		return true;
	}

	//Delete project
	public function deleteStory($storyId) {
		$user = $_SESSION['user'];
		$projectId = $user->activeProject;
		if (!$this->checkUserIsPartOfProject($projectId)) {
			return false;
		}

		$isDeleted = $this->storyDAL->deleteStory($projectId, $storyId);

		//Did deletion fail?
		if (!$isDeleted) {
			$this->notify->error('Could not delete story.');
			return false;
		}

		//Story succesfully deleted (present message?)
		return true;
	}

	//Fetch story
	public function getStory($storyId) {
		$user = $_SESSION['user'];
		$projectId = $user->activeProject;
		$foundStory = $this->storyDAL->getStory($projectId, $storyId);

		//No story found?
		if (!$foundStory) {
			$this->notify->error('Could not find story.');
			return false;
		}

		//Story found!
		return $foundStory;
	}

	//Update story
	public function updateStory($story) {
		$projectId = $_SESSION['user']->activeProject;
		$updateStory = new Story($story);
		//Validate
		if (!$this->validateStory($updateStory)) {
			return false;
		}
		$isUpdated = $this->storyDAL->updateStory($updateStory, $projectId);

		//Was it updated?
		if ($isUpdated) {
			$this->notify->success('Story successfully updated.');
			return true;
		} else {
			$this->notify->error('Failed to update story.');
			return false;
		}
	}

	//Set status of story
	public function setStatus($projectId, $storyId, $status) {
		$isUpdated = $this->storyDAL->setStatus($projectId, $storyId, $status);

		//Did it fail?
		if (!$isUpdated) {
			$this->notify->error('Could not change status');
		}
	}

	//Validation
	//name required, max: 50
	//description required, max: 250
	public function validateStory(Story $story) {
		$valid = true;
		if (!$story->name) {
			$this->notify->error('Story name is missing.');
			$valid = false;
		}
		if (strlen($story->name) >= 50) {
			$this->notify->error('Story name is too long, maximum 50.');
			$valid = false;
		}
		if (!$story->description) {
			$this->notify->error('Story description is missing.');
			$valid = false;
		}
		if (strlen($story->name) >= 250) {
			$this->notify->error('Story description is too long, maximum 250.');
			$valid = false;
		}

		return $valid;
	}

	public function __construct() {
		parent::__construct();
		$this->projectDAL = new ProjectDAL();
		$this->storyDAL = new StoryDAL();
	}
}
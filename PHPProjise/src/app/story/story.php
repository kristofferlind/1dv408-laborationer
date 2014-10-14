<?php

class Story {
	public $storyId;
	public $projectId;
	public $name;
	public $description;
	public $storyStatusId;

	public function __construct($story) {
		if (is_array($story)) {
			if (isset($story['storyId'])) {
				$this->storyId = $story['storyId'];
				$this->projectId = $story['projectId'];
				$this->storyStatusId = $story['storyStatusId'];
			} else {
				$this->storyId = '';
				$this->projectId = '';
				$this->storyStatusId = '';
			}
			$this->name = $story['name'];
			$this->description = $story['description'];
		} else {
			$this->storyId = $story->storyId;
			$this->name = $story->name;
			$this->description = $story->description;
		}
		$this->validate();
	}

	//Validation
	//name required, max: 50
	//description required, max: 250
	public function validate() {
		$validationErrors = array();

		if (!$this->name) {
			array_push($validationErrors, new ValidationError('Story name is missing', 'ValidationError!'));
		}
		if (strlen($this->name) > 50) {
			array_push($validationErrors, new ValidationError('Story name is too long, maximum 50', 'ValidationError!'));
		}
		if (!$this->description) {
			array_push($validationErrors, new ValidationError('Story description is missing', 'ValidationError!'));
		}
		if (strlen($this->description) > 250) {
			array_push($validationErrors, new ValidationError('Story description is too long, maximum 250', 'ValidationError!'));
		}

		if (count($validationErrors) > 0) {
			throw new ValidationException($validationErrors);
		}
	}
}

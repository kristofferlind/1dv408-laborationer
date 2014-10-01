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
	}
}
<?php

class StoryDAL extends BaseDAL {
	
	private $stories;
	
	public function __construct() {
		parent::__construct();

		//Use a storyList like in the lectures?
		$this->stories = array();
	}

	//Fetch all stories for project
	public function getStories($projectId) {
		$db = $this->connection();
		$sql = 'SELECT storyId, projectId, name, description, storyStatusId ';
		$sql .= 'FROM story WHERE projectId = :projectId';
		$params = array(':projectId' => $projectId);
		$query = $db->prepare($sql);
		$query->execute($params);
		$stories = $query->fetchAll();

		//No stories?
		if ($stories === null) {
			return false;
		}

		foreach ($stories as $story) {
			$this->stories[$story['storyId']] = new Story($story);
		}

		return $this->stories;
	}

	//Create story
	public function createStory(Story $story, $projectId) {
		$db = $this->connection();
		$sql = 'INSERT INTO story (projectId, name, description, storyStatusId) VALUES (:projectId, :name, :description, :storyStatusId)';
		$params = array(':projectId' => $projectId, ':name' => $story->name, ':description' => $story->description, ':storyStatusId' => 1);
		$query = $db->prepare($sql);
		$status = $query->execute($params);

		return $status;
	}

	//Delete story
	public function deleteStory($projectId, $storyId) {
		$db = $this->connection();
		$sql = 'DELETE FROM story WHERE projectId = :projectId AND storyId = :storyId';
		$params = array(':projectId' => $projectId, ':storyId' => $storyId);
		$query = $db->prepare($sql);
		$status = $query->execute($params);

		return $status;
	}

	//Fetch story
	public function getStory($projectId, $storyId) {
		$db = $this->connection();
		$sql = 'SELECT * FROM story WHERE projectId = :projectId AND storyId = :storyId';
		$params = array(':projectId' => $projectId, ':storyId' => $storyId);
		$query = $db->prepare($sql);
		$status = $query->execute($params);

		//Did it fail?
		if (!$status) {
			return false;
		}

		$story = $query->fetchObject();

		//Make sure there was something to fetch
		if ($story === null) {
			return false;
		}

		$returnStory = new Story($story);

		//Successfully fetched story
		return $returnStory;
	}

	//Update story
	public function updateStory(Story $story, $projectId) {
		$db = $this->connection();
		$sql = 'UPDATE story SET name = :name, description = :description WHERE projectId = :projectId AND storyId = :storyId';
		$params = array(':name' => $story->name, ':description' => $story->description, ':projectId' => $projectId, ':storyId' => $story->storyId);
		$query = $db->prepare($sql);
		$status = $query->execute($params);

		//Was it successful?
		if ($status) {
			return true;
		}

		return false;
	}

	//Change status of story
	public function setStatus($projectId, $storyId, $status) {
		$db = $this->connection();
		$sql = 'UPDATE story SET storyStatusId = :status WHERE projectId = :projectId AND storyId = :storyId';
		$params = array(':status' => $status, ':projectId' => $projectId, ':storyId' => $storyId);
		$query = $db->prepare($sql);
		$status = $query->execute($params);

		//Was it successfully changed?
		if ($status) {
			return true;
		}

		return false;
	}
}
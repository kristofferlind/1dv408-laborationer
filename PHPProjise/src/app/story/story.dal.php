<?php

class StoryDAL extends BaseDAL {
	
	private $stories;
	private static $table = 'story';
	private static $key = 'storyId';
	private static $projectKey = 'projectId';
	private static $name = 'name';
	private static $description = 'description';
	private static $status = 'storyStatusId';
	
	public function __construct() {
		parent::__construct();

		//Use a storyList like in the lectures?
		$this->stories = array();
	}

	//Fetch all stories for project
	public function getStories($projectKey) {
		$db = $this->connection();
		// SELECT storyId, projectId, name, description, storyStatusId
		// FROM story WHERE projectId = :projectId
		$sql = 'SELECT ' . self::$key . ', ' . self::$projectKey . ', ' . self::$name . ', ' . self::$description . ', ' . self::$status . ' ';
		$sql .= 'FROM ' . self::$table . ' WHERE ' . self::$projectKey . ' = :' . self::$projectKey;
		$params = array(':' . self::$projectKey => $projectKey);
		$query = $db->prepare($sql);
		$query->execute($params);
		$stories = $query->fetchAll();

		//No stories?
		if ($stories === null) {
			return false;
		}

		foreach ($stories as $story) {
			$this->stories[$story[self::$key]] = new Story($story);
		}

		return $this->stories;
	}

	//Create story
	public function createStory(Story $story, $projectKey) {
		$db = $this->connection();
		// INSERT INTO story (projectId, name, description, storyStatusId) VALUES (:projectId, :name, :description, :storyStatusId)
		$sql = 'INSERT INTO ' . self::$table . ' (' . self::$projectKey . ', ' . self::$name . ', ' . self::$description . ', ' . self::$status . ') ';
		$sql .= 'VALUES (:' . self::$projectKey . ', :' . self::$name . ', :' . self::$description . ', :' . self::$status . ')';
		$params = array(':' . self::$projectKey => $projectKey, ':' . self::$name => $story->name, ':' . self::$description => $story->description, ':' . self::$status => StoryStatus::NotDone);
		$query = $db->prepare($sql);
		$status = $query->execute($params);

		return $status;
	}

	//Delete story
	public function deleteStory($projectKey, $key) {
		$db = $this->connection();
		// $sql = 'DELETE FROM story WHERE projectId = :projectId AND storyId = :storyId';
		$sql = 'DELETE FROM ' . self::$table . ' WHERE ' . self::$projectKey . ' = :' . self::$projectKey . ' AND ' . self::$key . ' = :' . self::$key;
		$params = array(':' . self::$projectKey => $projectKey, ':' . self::$key => $key);
		// $params = array(':projectId' => $projectId, ':storyId' => $storyId);
		$query = $db->prepare($sql);
		$status = $query->execute($params);

		return $status;
	}

	//Fetch story
	public function getStory($projectId, $storyId) {
		$db = $this->connection();
		//SELECT * FROM story WHERE projectId = :projectId AND storyId = :storyId
		$sql = 'SELECT * FROM ' . self::$table . ' WHERE ' . self::$projectKey . ' = :' . self::$projectKey . ' AND ' . self::$key . ' = :' . self::$key;
		$params = array(':' . self::$projectKey => $projectId, ':' . self::$key => $storyId);
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
	public function updateStory(Story $story, $projectKey) {
		$db = $this->connection();
		//UPDATE story SET name = :name, description = :description WHERE projectId = :projectId AND storyId = :storyId
		$sql = 'UPDATE ' . self::$table . ' SET ' . self::$name . ' = :' . self::$name . ', ' . self::$description . ' = :' . self::$description . ' WHERE ' . self::$projectKey . ' = :' . self::$projectKey . ' AND ' . self::$key . ' = :' . self::$key;
		$params = array(':' . self::$name => $story->name, ':' . self::$description => $story->description, ':' . self::$projectKey => $projectKey, ':' . self::$key => $story->storyId);
		$query = $db->prepare($sql);
		$status = $query->execute($params);

		//Was it successful?
		if ($status) {
			return true;
		}

		return false;
	}

	//Change status of story
	public function setStatus($projectKey, $key, $status) {
		$db = $this->connection();
		// UPDATE story SET storyStatusId = :status WHERE projectId = :projectId AND storyId = :storyId
		$sql = 'UPDATE ' . self::$table . ' SET ' . self::$status . ' = :' . self::$status . ' WHERE ' . self::$projectKey . ' = :' . self::$projectKey . ' AND ' . self::$key . ' = :' . self::$key;
		// $sql = 'UPDATE story SET storyStatusId = :status WHERE projectId = :projectId AND storyId = :storyId';
		$params = array(':' . self::$status => $status, ':' . self::$projectKey => $projectKey, ':' . self::$key => $key);
		$query = $db->prepare($sql);
		$status = $query->execute($params);

		//Was it successfully changed?
		if ($status) {
			return true;
		}

		return false;
	}
}
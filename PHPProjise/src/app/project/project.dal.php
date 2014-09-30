<?php

class ProjectDAL extends BaseDAL {

	private $projects;
	
	public function __construct() {
		parent::__construct();

		//Use a projectList like in the lectures?
		$this->projects = array();
	}

	public function getProjectsByUserId($userId) {
		$db = $this->connection();
		$sql  = 'SELECT projects.projectId, projects.name, projects.description ';
		$sql .= 'FROM users INNER JOIN userProjects ';
		$sql .= 'ON users.userId = userProjects.userId INNER JOIN projects ';
		$sql .= 'ON userProjects.projectId = projects.projectId ';
		$sql .= 'WHERE users.userId = :userId';
		$params = array(':userId' => $userId);
		$query = $db->prepare($sql);
		$query->execute($params);
		$projects = $query->fetchAll();

		if ($projects === null) {
			return false;
		}

		foreach ($projects as $project) {
			$this->projects[$project['projectId']] = new Project($project);
		}

		return $this->projects;
	}

	//This should be a transaction
	public function addProject(Project $project, $userId) {
		$db = $this->connection();
		$projectSql = 'INSERT INTO projects (name, description) VALUES (:name, :description)';
		$projectParams = array(':name' => $project->name, ':description' => $project->description);
		$projectQuery = $db->prepare($projectSql);
		$projectStatus = $projectQuery->execute($projectParams);
		$projectId = $db->lastInsertId();


		if ($projectStatus) {
			$userProjectSql = 'INSERT INTO userProjects (userId, projectId) VALUES (:userId, :projectId)';
			$userProjectParams = array(':userId' => $userId, ':projectId' => $projectId);
			$userProjectQuery = $db->prepare($userProjectSql);
			$userProjectStatus = $userProjectQuery->execute($userProjectParams);

			if ($userProjectStatus) {
				return true;
			}
		}

		return false;
	}

	public function updateProject(Project $project) {
		$db = $this->connection();
		$sql = 'UPDATE projects SET name = :name, description = :description WHERE projectId = :projectId';
		$params = array(':name' => $project->name, ':description' => $project->description, ':projectId' => $project->projectId);
		$query = $db->prepare($sql);
		$status = $query->execute($params);

		if ($status) {
			return true;
		}

		return false;
	}

	public function checkUserIsPartOfProject($userId, $projectId) {
		$db = $this->connection();
		$sql = 'SELECT * FROM userProjects WHERE userId = :userId AND projectId = :projectId';
		$params = array(':userId' => $userId, ':projectId' => $projectId);
		$query = $db->prepare($sql);
		$result = $query->execute($params);

		if (!$result) {
			return false;
		}

		$user = $query->fetchAll();
		if ($user === null) {
			return false;
		}

		return true;
	}

	public function getProject($projectId) {
		$db = $this->connection();
		$sql = 'SELECT * FROM projects WHERE projectId = :projectId';
		$params = array(':projectId' => $projectId);
		$query = $db->prepare($sql);
		$status = $query->execute($params);

		if (!$status) {
			return false;
		}

		$project = $query->fetchObject();

		if ($project === null) {
			return false;
		}

		$returnProject = new Project($project);

		return $returnProject;
	}

	public function deleteProject($projectId) {
		$db = $this->connection();
		$sql = 'DELETE FROM projects WHERE projectId = :projectId';
		$params = array(':projectId' => $projectId);
		$query = $db->prepare($sql);
		$result = $query->execute($params);

		if ($result) {
			$sql2 = 'DELETE FROM userProjects WHERE projectId = :projectId';
			$query2 = $db->prepare($sql);
			$result2 = $query2->execute($params);

			if ($result2) {
				return true;
			}
		}

		return false;
	}
}

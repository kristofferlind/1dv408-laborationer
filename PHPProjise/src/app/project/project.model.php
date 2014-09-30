<?php

class ProjectModel extends BaseModel {

	private $projectDAL;

	public function getProjects() {
		$user = $_SESSION['user'];
		$projects = $this->projectDAL->getProjectsByUserId($user->userId);
		if ($projects === null) {
			return false;
		}
		return $projects;
	}

	public function createProject($projectData) {
		$user = $_SESSION['user'];
		$project = new Project($projectData);
		$createdProject = $this->projectDAL->addProject($project, $user->userId);

		if ($createdProject === null) {
			$this->notify->error('Failed to create project.');
			return false;
		}

		return true;
	}

	public function deleteProject($projectId) {
		//make sure user is part of project
		$user = $_SESSION['user'];
		$isPartOf = $this->projectDAL->checkUserIsPartOfProject($user->userId, $projectId);
		
		if (!$isPartOf) {
			$this->notify->error('You cannot delete a project you are not a member of.');
			return false;
		}
		
		//delete project
		$isDeleted = $this->projectDAL->deleteProject($projectId);

		if (!$isDeleted) {
			$this->notify->error("Couldn't delete project.");
			return false;
		}

		return true;
	}

	public function getProject($projectId) {
		$user = $_SESSION['user'];
		$isPartOf = $this->projectDAL->checkUserIsPartOfProject($user->userId, $projectId);

		if (!$isPartOf) {
			$this->notify->error('You cannot edit a project you are not a member of.');
			return false;
		}

		$foundProject = $this->projectDAL->getProject($projectId);

		if (!$foundProject) {
			$this->notify->error('Could not find project.');
			return false;
		}

		return $foundProject;
	}

	public function updateProject($project) {
		$updateProject = new Project($project);
		$isUpdated = $this->projectDAL->updateProject($updateProject);

		if ($isUpdated) {
			return true;
		} else {
			$this->notify->error('Failed to update project.');
			return false;
		}
	}

	public function __construct() {
		parent::__construct();
		$this->projectDAL = new ProjectDAL();
	}
}
<?php

class ProjectModel extends BaseModel {

	private $projectDAL;

	//Fetch projects user is part of
	public function getProjects() {
		$user = $_SESSION['user'];
		$projects = $this->projectDAL->getProjectsByUserId($user->userId);

		//Is user part of any project?
		if ($projects === null) {
			return false;
		}
		return $projects;
	}

	//Create project
	public function createProject($projectData) {
		$user = $_SESSION['user'];
		$project = new Project($projectData);

		//Validate
		if (!$this->validateProject($project)) {
			return false;
		}

		$createdProject = $this->projectDAL->addProject($project, $user->userId);

		//Did creation fail?
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
		
		//Is user part of project?
		if (!$isPartOf) {
			$this->notify->error('You cannot delete a project you are not a member of.');
			return false;
		}
		
		//Delete project
		$isDeleted = $this->projectDAL->deleteProject($projectId);

		//Did deletion fail?
		if (!$isDeleted) {
			$this->notify->error("Couldn't delete project.");
			return false;
		}

		//Deletion successful
		return true;
	}

	//Fetch project
	public function getProject($projectId) {
		$user = $_SESSION['user'];
		$isPartOf = $this->projectDAL->checkUserIsPartOfProject($user->userId, $projectId);

		//Make sure user is part of project
		if (!$isPartOf) {
			$this->notify->error('You cannot edit a project you are not a member of.');
			return false;
		}

		$foundProject = $this->projectDAL->getProject($projectId);

		//No project found?
		if (!$foundProject) {
			$this->notify->error('Could not find project.');
			return false;
		}

		return $foundProject;
	}

	//Update project
	public function updateProject($project) {
		$updateProject = new Project($project);

		if (!$this->validateProject($updateProject)) {
			return false;
		}

		//Try to update
		$isUpdated = $this->projectDAL->updateProject($updateProject);

		//Was update successful?
		if ($isUpdated) {
			$this->notify->success('Project successfully updated.');
			return true;
		} else {
			$this->notify->error('Failed to update project.');
			return false;
		}
	}

	//Set active project
	public function activateProject($projectId) {
		$user = $_SESSION['user'];
		$user->activeProject = $projectId;
		$_SESSION['user'] = $user;
	}

	//Validate project (should probably be in Project)
	//name should exist and be at most 50chars
	//description should exist and be at most 250chars
	public function validateProject(Project $project) {
		$valid = true;
		if (!$project->name) {
			$this->notify->error('Project name is missing.');
			$valid = false;
		}
		if (strlen($project->name) >= 50) {
			$this->notify->error('Project name is too long, maximum 50.');
			$valid = false;
		}
		if (!$project->description) {
			$this->notify->error('Project description is missing.');
			$valid = false;
		}
		if (strlen($project->name) >= 250) {
			$this->notify->error('Project description is too long, maximum 250.');
			$valid = false;
		}

		return $valid;
	}

	public function __construct() {
		parent::__construct();
		$this->projectDAL = new ProjectDAL();
	}
}
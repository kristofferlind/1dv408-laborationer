<?php

class ProjectModel extends BaseModel {

	private $projectDAL;

	//Fetch projects user is part of
	public function getProjects() {		
		$projects = $this->projectDAL->getProjectsByUserId($this->user->userId);

		//Is user part of any project?
		if ($projects === null) {
			return false;
		}
		return $projects;
	}

	//Create project
	public function createProject($projectData) {
		$project = new Project($projectData);

		$createdProject = $this->projectDAL->addProject($project, $this->user->userId);

		//Did creation fail?
		if ($createdProject === null) {
			$this->notify->error('Failed to create project.');
			return false;
		}

		return true;
	}

	public function deleteProject($projectId) {
		//make sure user is part of project
		$isPartOf = $this->projectDAL->checkUserIsPartOfProject($this->user->userId, $projectId);
		
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
		$isPartOf = $this->projectDAL->checkUserIsPartOfProject($this->user->userId, $projectId);

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
		$this->user->activeProject = $projectId;
	}

	public function __construct() {
		parent::__construct();
		$this->projectDAL = new ProjectDAL();
	}
}
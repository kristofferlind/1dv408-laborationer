<?php

class Project {
	public $projectId;
	public $name;
	public $description;

	public function __construct($project) {
		if (is_array($project)) {
			if (isset($project['projectId'])) {
				$this->projectId = $project['projectId'];
			} else {
				$this->projectId = '';
			}
			$this->name = $project['name'];
			$this->description = $project['description'];
		} else {
			$this->projectId = $project->projectId;
			$this->name = $project->name;
			$this->description = $project->description;
		}
	}
}
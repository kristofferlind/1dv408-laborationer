<?php

class Project {
	public $projectId;
	public $name;
	public $description;

	public function __construct($project) {
		//If array (for constructing from formData and some db responses)
		if (is_array($project)) {
			//Is it a db response? (formdata won't have projectId)
			if (isset($project['projectId'])) {
				$this->projectId = $project['projectId'];
			} else {
				$this->projectId = '';
			}
			$this->name = $project['name'];
			$this->description = $project['description'];
		} else {
			//db object
			$this->projectId = $project->projectId;
			$this->name = $project->name;
			$this->description = $project->description;
		}
	}
}
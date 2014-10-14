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

		$this->validate();
	}

	//Validation
	//name should exist and be at most 50chars
	//description should exist and be at most 250chars
	public function validate() {
		$validationErrors = array();

		if (!$this->name) {
			array_push($validationErrors, new ValidationError('Project name is missing'));
		}
		if (strlen($this->name) > 50) {
			array_push($validationErrors, new ValidationError('Project name is too long, maximum 50'));
		}
		if (!$this->description) {
			array_push($validationErrors, new ValidationError('Project description is missing'));
		}
		if (strlen($this->description) > 250) {
			array_push($validationErrors, new ValidationError('Project description is too long, maximum 250'));
		}

		if (count($validationErrors) > 0) {
			throw new ValidationException($validationErrors);
		}
	}
}
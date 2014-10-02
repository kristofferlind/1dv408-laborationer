<?php

class ProjectEditView extends BaseView {
	//Does user want to update?
	public function didUpdate() {
		return isset($_POST['update']);
	}

	//Fetch formdata from edit form
	public function getEditProjectFormData() {
		$projectData = array();
		//Encode input 
		$projectData['name'] = htmlspecialchars($_POST['name']);
		$projectData['description'] = htmlspecialchars($_POST['description']);
		return $projectData;		
	}

	public function index($project) {
		$id = $project->projectId;
		$name = $project->name;
		$description = $project->description;
		return "
				<h1>Edit project</h1>
				<form action='?section=project&page=edit&id=$id' method='post'>
					<div class='form-group'>
						<label for='create-project-name'>Name</label>
						<input autofocus required maxlength='50' value='$name' type='text' class='form-control' id='create-project-name' name='name' placeholder='Project name'>
					</div>
					<div class='form-group'>
						<label for='create-project-description'>Description</label>
						<textarea required maxlength='250' type='text' class='form-control' id='create-project-description' name='description' placeholder='Project description'>$description</textarea>
					</div>
					<button type='submit' class='btn btn-primary' name='update'>Update</button>
				</form>";
	}
}
<?php

class ProjectEditView extends BaseView {
	public function didUpdate() {
		return isset($_POST['update']);
	}

	public function getEditProjectFormData() {
		$projectData = array();
		$projectData['name'] = $_POST['name'];
		$projectData['description'] = $_POST['description'];
		return $projectData;		
	}

	public function index($project) {
		$id = $project->projectId;
		$name = $project->name;
		$description = $project->description;
		return "
				<h1>Edit project</h1>
				<form action='?section=project&page=edit&action=create&id=$id' method='post'>
					<div class='form-group'>
						<label for='create-project-name'>Name</label>
						<input value='$name' type='text' class='form-control' id='create-project-name' name='name' placeholder='Project name'>
					</div>
					<div class='form-group'>
						<label for='create-project-description'>Description</label>
						<input value='$description' type='text' class='form-control' id='create-project-description' name='description' placeholder='Project description'>
					</div>
					<button type='submit' class='btn btn-primary' name='update'>Update</button>
				</form>";
	}
}
<?php

class ProjectListView extends BaseView {
	//Does user want to create project?
	public function didCreate() {
		return isset($_POST['create']);
	}

	//Fetch project creation form data
	public function getCreateFormData() {
		$formData = array();
		$formData['name'] = htmlspecialchars($_POST['name']);
		$formData['description'] = htmlspecialchars($_POST['description']);
		return $formData;
	}

	//Generate table from projectlist
	private function generateTable($projects, $activeProjectId) {
		$table = "
				<table class='table table-hover'>
					<tr>
						<th>Name</th>
						<th>Description</th>
						<th>Actions</th>
					</tr>";
		foreach ($projects as $project) {
			$table .= $this->generateRow($project, $activeProjectId);
		}
		$table .= "</table>";

		return $table;
	}

	//Generate tablerow
	private function generateRow($project, $activeProjectId) {
		$name = $project->name;
		$description = $project->description;
		$projectId = $project->projectId;
		
		// Check if this project is the furrent project
		if ($project->projectId !== $activeProjectId) {
			$activeClass = "";
			$activateButton = "
						<a href='?section=project&page=index&action=activate&id=$projectId'>
							<button data-toggle='tooltip' title='Activate project' type='button' class='btn btn-success btn-xs'>
								<span class='glyphicon glyphicon-ok'></span>
							</button>
						</a> ";
		} else {
			$activeClass = "class='success'";
			$activateButton = '';
		}

		$row = "
				<tr $activeClass>
					<td>$name</td>
					<td>$description</td>
					<td class='actions'>
						$activateButton
						<a href='?section=project&page=edit&id=$projectId'>
							<button data-toggle='tooltip' title='Edit project' type='button' class='btn btn-primary btn-xs'>
								<span class='glyphicon glyphicon-pencil'></span>
							</button>
						</a>
						<a href='?section=project&page=index&action=delete&id=$projectId'>
							<button data-toggle='tooltip' title='Delete project' type='button' class='btn btn-danger btn-xs'>
								<span class='glyphicon glyphicon-trash'></span>
							</button>
						</a>
					</td>
				</tr>";

		return $row;
	}

	public function index($projects, $model) {
		$activeProjectId = $model->getActiveProject();
		$createProjectForm = "
							<form action='?section=project&page=index&action=create' method='post'>
								<div class='form-group'>
									<label for='create-project-name'>Name</label>
									<input autofocus required maxlength='50' type='text' class='form-control' id='create-project-name' name='name' placeholder='Project name'>
								</div>
								<div class='form-group'>
									<label for='create-project-description'>Description</label>
									<textarea required maxlength='250' type='text' class='form-control' id='create-project-description' name='description' placeholder='Project description'></textarea>
								</div>
								<button type='submit' class='btn btn-primary' name='create'>Create</button>
							</form>";
		$createProjectModal = "
							<div class='modal fade' id='create-project'>
								<div class='modal-dialog'>
									<div class='modal-content'>
										<div class='modal-header'>
											<button type='button' class='close' data-dismiss='modal'><span>&times;</span></button>
					        				<h2 class='modal-title'>Create project</h2>
										</div>
										<div class='modal-body'>
											$createProjectForm
										</div>
									</div>
								</div>
							</div>";
		$table = $this->generateTable($projects, $activeProjectId);
		return "
				<div class='toolbar'>
					<button type='button' class='btn btn-success' data-toggle='modal' data-target='#create-project'>
						<span class='glyphicon glyphicon-plus-sign'></span> Create project
					</button>
				</div>
				<h1>Projects <small>manage projects</small></h1>
				$table
				$createProjectModal";
	}
}
<?php

class ProjectListView extends BaseView {
	public function didCreate() {
		return isset($_POST['create']);
	}

	public function getCreateFormData() {
		$formData = array();
		$formData['name'] = $_POST['name'];
		$formData['description'] = $_POST['description'];
		return $formData;
	}

	private function generateTable($projects) {
		$table = "<table class='table table-hover'><tr><td>Name</td><td>Description</td><td>Actions</td></tr>";
		foreach ($projects as $project) {
			$table .= $this->generateRow($project);
		}
		$table .= "</table>";

		return $table;
	}

	private function generateRow($project) {
		$name = $project->name;
		$description = $project->description;
		$projectId = $project->projectId;
		$row = "
				<tr>
					<td>$name</td>
					<td>$description</td>
					<td class='actions'>
						<a href='?section=project&page=edit&id=$projectId'>
							<button type='button' class='btn btn-primary btn-xs'>
								<span class='glyphicon glyphicon-pencil'></span>
							</button>
						</a>
						<a href='?section=project&page=index&action=delete&id=$projectId'>
							<button type='button' class='btn btn-danger btn-xs'>
								<span class='glyphicon glyphicon-trash'></span>
							</button>
						</a>
					</td>
				</tr>";

		return $row;
	}

	public function index($projects) {
		$createProjectForm = "
							<form action='?section=project&page=index&action=create' method='post'>
								<div class='form-group'>
									<label for='create-project-name'>Name</label>
									<input type='text' class='form-control' id='create-project-name' name='name' placeholder='Project name'>
								</div>
								<div class='form-group'>
									<label for='create-project-description'>Description</label>
									<input type='text' class='form-control' id='create-project-description' name='description' placeholder='Project description'>
								</div>
								<button type='submit' class='btn btn-primary' name='create'>Create</button>
							</form>";
		$createProjectModal = "
							<div class='modal fade' id='create-project' tabindex='-1'>
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
		$table = $this->generateTable($projects);
		return "
				<div class='toolbar'>
					<button type='button' class='btn btn-success' data-toggle='modal' data-target='#create-project'>
						<span class='glyphicon glyphicon-plus-sign'></span> Create project
					</button>
				</div>
				<h1>Projects <small>shows your projects</small></h1>
				$table
				$createProjectModal";
	}
}
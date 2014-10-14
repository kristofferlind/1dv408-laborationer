<?php

class StoryListView extends BaseView {
	
	//Does user want to create a story?
	public function didCreate() {
		return isset($_POST['create']);
	}

	//Fetch form data from create story form
	public function getCreateFormData() {
		$formData = array();
		$formData['name'] = htmlspecialchars($_POST['name']);
		$formData['description'] = htmlspecialchars($_POST['description']);
		return $formData;
	}

	//Generate table of stories
	private function generateTable($stories) {
		if (!$stories) {
			return '';
		}
		$table = "
				<table class='table table-hover'>
					<tr>
						<th>Name</th>
						<th>Description</th>
						<th class='actions'>Actions</th>
					</tr>";
		foreach ($stories as $story) {
			$table .= $this->generateRow($story);
		}
		$table .= "</table>";

		return $table;
	}

	//Generate status buttons based on status (should use enum)
	private function generateSetStatusButton($story) {
		$storyId = $story->storyId;
		switch ($story->storyStatusId) {
			case StoryStatus::NotDone: 
				return "<a href='?section=story&page=index&action=work&id=$storyId'>
							<button data-toggle='tooltip' title='Work on story' type='button' class='btn btn-success btn-xs'>
								<span class='glyphicon glyphicon-ok'></span>
							</button>
						</a>";
				break;
			case StoryStatus::InProgress:
				return "<a href='?section=story&page=index&action=finish&id=$storyId'>
							<button data-toggle='tooltip' title='Finish story' type='button' class='btn btn-success btn-xs'>
								<span class='glyphicon glyphicon-thumbs-up'></span>
							</button>
						</a>
						<a href='?section=story&page=index&action=cancel&id=$storyId'>
							<button data-toggle='tooltip' title='Cancel work on story' type='button' class='btn btn-warning btn-xs'>
								<span class='glyphicon glyphicon-thumbs-down'></span>
							</button>
						</a>";
				break;
			case StoryStatus::Done:
				return "<a href='?section=story&page=index&action=work&id=$storyId'>
							<button data-toggle='tooltip' title='Work on story' type='button' class='btn btn-warning btn-xs'>
								<span class='glyphicon glyphicon-thumbs-down'></span>
							</button>
						</a>";
				break;
		}
	}

	//Generate row for table
	private function generateRow($story) {
		$name = $story->name;
		$description = $story->description;
		$storyId = $story->storyId;
		$setStatusButton = $this->generateSetStatusButton($story);

		$row = "
				<tr>
					<td>$name</td>
					<td class='td-wide'>$description</td>
					<td class='actions'>
						$setStatusButton
						<a href='?section=story&page=edit&id=$storyId'>
							<button data-toggle='tooltip' title='Edit story' type='button' class='btn btn-primary btn-xs'>
								<span class='glyphicon glyphicon-pencil'></span>
							</button>
						</a>
						<a href='?section=story&page=index&action=delete&id=$storyId'>
							<button data-toggle='tooltip' title='Delete story' type='button' class='btn btn-danger btn-xs'>
								<span class='glyphicon glyphicon-trash'></span>
							</button>
						</a>
					</td>
				</tr>";

		return $row;
	}

	public function index($stories) {
		$createStoryForm = "
							<form action='?section=story&page=index&action=create' method='post'>
								<div class='form-group'>
									<label for='create-story-name'>Name</label>
									<input autofocus required maxlength='50' type='text' class='form-control' id='create-story-name' name='name' placeholder='Story name'>
								</div>
								<div class='form-group'>
									<label for='create-story-description'>Description</label>
									<textarea required maxlength='250' type='text' class='form-control' id='create-story-description' name='description' placeholder='Story description'></textarea>
								</div>
								<button type='submit' class='btn btn-primary' name='create'>Create</button>
							</form>";
		$createStoryModal = "
							<div class='modal fade' id='create-story'>
								<div class='modal-dialog'>
									<div class='modal-content'>
										<div class='modal-header'>
											<button type='button' class='close' data-dismiss='modal'><span>&times;</span></button>
					        				<h2 class='modal-title'>Create story</h2>
										</div>
										<div class='modal-body'>
											$createStoryForm
										</div>
									</div>
								</div>
							</div>";

		$tableNotDone = '';
		$tableInProgress = '';
		$tableDone = '';

		if (isset($stories['notDone'])) {
			$tableNotDone = $this->generateTable($stories['notDone']);
		}
		if (isset($stories['inProgress'])) {
			$tableInProgress = $this->generateTable($stories['inProgress']);
		}
		if (isset($stories['done'])) {
			$tableDone = $this->generateTable($stories['done']);
		}
		
		return "
				<div class='toolbar'>
					<button type='button' class='btn btn-success' data-toggle='modal' data-target='#create-story'>
						<span class='glyphicon glyphicon-plus-sign'></span> Create story
					</button>
				</div>
				<h1>Stories <small>manage stories</small></h1>
				<hr>
				<div class='row'>
					<div class='col-md-6'>
						<h3>Not started</h3>
						$tableNotDone
					</div>
					<div class='col-md-6'>
						<h3>In progress</h3>
						$tableInProgress
					</div>
				</div>
				<h3>Finished</h3>
				$tableDone

				$createStoryModal";
	}
	
}
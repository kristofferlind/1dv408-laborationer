<?php

class StoryEditView extends BaseView {
	public function didUpdate() {
		return isset($_POST['update']);
	}

	public function getEditStoryFormData() {
		$storyData = array();
		$storyData['name'] = $_POST['name'];
		$storyData['description'] = $_POST['description'];
		return $storyData;		
	}

	public function index($story) {
		$id = $story->storyId;
		$name = $story->name;
		$description = $story->description;
		return "
				<h1>Edit story</h1>
				<form action='?section=story&page=edit&action=create&id=$id' method='post'>
					<div class='form-group'>
						<label for='create-story-name'>Name</label>
						<input value='$name' type='text' class='form-control' id='create-story-name' name='name' placeholder='Story name'>
					</div>
					<div class='form-group'>
						<label for='create-story-description'>Description</label>
						<input value='$description' type='text' class='form-control' id='create-story-description' name='description' placeholder='Story description'>
					</div>
					<button type='submit' class='btn btn-primary' name='update'>Update</button>
				</form>";
	}
}
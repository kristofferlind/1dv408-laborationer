<?php

class StoryEditView extends BaseView {
	//Does user want to update story?
	public function didUpdate() {
		return isset($_POST['update']);
	}

	//Fetch formdata from edit form
	public function getEditStoryFormData() {
		$storyData = array();
		$storyData['name'] = htmlspecialchars($_POST['name']);
		$storyData['description'] = htmlspecialchars($_POST['description']);
		return $storyData;		
	}

	//Story edit view
	public function index($story) {
		$id = $story->storyId;
		$name = $story->name;
		$description = $story->description;
		return "
				<h1>Edit story</h1>
				<form action='?section=story&page=edit&action=create&id=$id' method='post'>
					<div class='form-group'>
						<label for='create-story-name'>Name</label>
						<input autofocus value='$name' type='text' class='form-control' id='create-story-name' name='name' placeholder='Story name'>
					</div>
					<div class='form-group'>
						<label for='create-story-description'>Description</label>
						<textarea type='text' class='form-control' id='create-story-description' name='description' placeholder='Story description'>$description</textarea>
					</div>
					<button type='submit' class='btn btn-primary' name='update'>Update</button>
				</form>";
	}
}
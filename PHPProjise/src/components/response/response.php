<?php

//Manages server responses (html, json?)
class Response {

	private function isActive($section) {
		$section = strtolower($section);
		if (!isset($_GET['section'])) {
			return '';
		}
		if ($section === $_GET['section'] || ($section === 'project' && $_GET['section'] === '')) {
			return "class='active'";
		} else {
			return '';
		}
	}

	private function renderNavLink($section) {
		$isActive = $this->isActive($section);
		$hrefTag = strtolower($section);
		return "<li $isActive><a href='?section=$hrefTag'>$section</a></li>";
	}

	private function RenderNav() {
		$project = $this->renderNavLink('Project');
		$story = $this->renderNavLink('Story');

		return "
		    <nav class='navbar navbar-inverse navbar-fixed-top' role='navigation'>
		      	<div class='container'>
		        	<div class='navbar-header'>
		          		<button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='.navbar-collapse'>
				            <span class='sr-only'>Toggle navigation</span>
				            <span class='icon-bar'></span>
				            <span class='icon-bar'></span>
				            <span class='icon-bar'></span>
		          		</button>
		          		<a class='navbar-brand' href='index.php'>Projise</a>
		        	</div>
		        	<div class='collapse navbar-collapse'>
		          		<ul class='nav navbar-nav'>
		            		$project
		            		$story
		          		</ul>
		        	</div>
		      	</div>
		    </nav>";
	}

	//Renders html page
	public function HTMLPage($body, $notifyView) {
		if ($body === NULL) {
			throw new Exception('HTMLView::echoHTML does not allow body to be null');
		}

		$notifications = '';
		$navigation = $this->RenderNav();

		//Don't fetch notifications on post, these pages should never be shown
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$notifications = $notifyView->showAll();
		}

		echo "
			<!DOCTYPE html>
			<html>
			<head>
				<title>1dv408, l2-login</title>
				<meta charset='utf-8'>
				<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
				<link rel='stylesheet' href='assets/css/style.css'>
			</head>
			<body>
				<div class='container'>
				$navigation
				<main>
				$notifications
				$body
				</main>
				</div>
				<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
			</body>
			</html>";
	}
}
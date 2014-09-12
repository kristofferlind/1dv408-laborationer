<?php

class Response {

	//Funktionen ger fel sträng, %e skulle ge rätt, men då blir det ingen utdata alls.
	private function customDate() {
		setlocale(LC_ALL, 'swedish');
		return strftime('%A, den %d %B %Y. Klockan är [%H:%M:%S].'); //%e pajar allt.. 
	}

	public function HTMLPage($body, $notify) {
		if ($body === NULL) {
			throw new \Exception('HTMLView::echoHTML does not allow body to be null');
		}

		$notifications = $notify->getAll();

		$date = $this->customDate();
		
		echo "
			<!DOCTYPE html>
			<html>
			<head>
				<meta charset='utf-8'>
				<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
			</head>
			<body>
				<div class='container'>
				$notifications
				$body
				<br />
				$date
				<hr>
				</div>
				<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
			</body>
			</html>";
	}
}
<?php

/*
Notification = {type, message}
type: error, success, info, warning
 */

class Notify {
	private $notifications;

	public function __construct() {
		$this->notifications = $_SESSION['notifications'];
	}

	private function clearArray() {
		unset($notifications);
		$this->prepareArray();
	}

	private function prepareArray() {
		$notifications = array();
		$_SESSION['notifications'] = $notifications;
		$this->notifications = $_SESSION['notifications'];
	}

	private function create($type, $header, $message) {
		if (!is_array($this->notifications)) {
			$this->prepareArray();
		}

		$notification = new Notification($type, $header, $message);
		array_push($this->notifications, $notification);
	}

	public function error($message, $header = 'Misslyckades!') {
		$this->create('danger', $header, $message);
	}

	public function info($message, $header = 'Info:') {
		$this->create('info', $header, $message);
	}

	public function success($message, $header = 'Lyckades!') {
		$this->create('success', $header, $message);
	}


	public function getAll() {
		$builtNotifications = '';

		if (is_array($this->notifications)) {
			foreach ($this->notifications as $notification) {
				$builtNotifications .= $this->buildNotification($notification);
			}
		}

		var_dump($this->notifications);
		$this->clearArray();

		return $builtNotifications;
	}

	private function buildNotification($notification) {
		$type = $notification->type;
		$header = $notification->header;
		$message = $notification->message;

		return "<div class='alert alert-$type alert-dismissible' role='alert'>
				  <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
				  <strong>$header</strong> $message
				</div>";
	}
}
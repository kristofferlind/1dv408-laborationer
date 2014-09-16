<?php

class Notify {

	public function __construct() {
		$this->prepareArray();
	}

	private function clearArray() {
		unset($_SESSION['notifications']);
		$this->prepareArray();
	}

	private function prepareArray() {
		if (!isset($_SESSION['notifications']) || !is_array($_SESSION['notifications'])) {
			$_SESSION['notifications'] = array();
		}
	}

	private function create($type, $header, $message) {
		$notification = new Notification($type, $header, $message);
		$notification = serialize($notification);
		$_SESSION['notifications'][] = $notification;
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

		if (count($_SESSION['notifications']) > 0) {
			foreach ($_SESSION['notifications'] as $notification) {
				$notification = unserialize($notification);
				$builtNotifications .= $this->buildNotification($notification);
			}
	
			$this->clearArray();
		}

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
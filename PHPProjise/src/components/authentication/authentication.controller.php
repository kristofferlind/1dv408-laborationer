<?php

class AuthenticationController extends BaseController {

	public function __construct() {
		parent::__construct();
		$auth = new AuthenticationModel();
		$view = new BaseView();

		//If user is not logged in
		if ($auth->isLoggedIn() === false) {
			//..redirect to login page
			$auth->notify->info('You need to be logged in to view this page. Please login to proceed.');
			$view->redirect('?section=account&page=index');
			return '';
		}
	}
}
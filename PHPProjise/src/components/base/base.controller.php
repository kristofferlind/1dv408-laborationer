<?php

class BaseController {
	protected $page;
	protected $action;
	protected $id;

	public function __construct() {
		$view = new BaseView();
		$this->page = $view->getPage();
		$this->action = $view->getAction();
		$this->id = $view->getId();
		$auth = new AuthenticationModel();

		$token = $view->getToken();
		$userAgent = $view->getUserAgent();
		$section = $view->getSection();
		$page = $view->getPage();
				
		if ($auth->isLoggedIn()) {
			if ($section === 'account' && $page === 'index') {
				//..then redirect to projectlist
				$view->redirect('?section=project&page=index');
			}
		}

		//Does token exist?
		if ($token !== '') {
			$loggedIn = $auth->tryLoadFromToken($token, $userAgent);
			//Did login with cookie work?
			if ($loggedIn) {
				//Was requested page the login page?
				if ($section === 'account' && $page === 'index') {
					//..then redirect to projectlist
					$view->redirect('?section=project&page=index');
				}
			} else {
				//Login with cookie failed, remove cookie
				$view->removeToken();
			}
		}
	}
}
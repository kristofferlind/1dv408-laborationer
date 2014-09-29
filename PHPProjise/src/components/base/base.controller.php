<?php

//maybe have?
//notify
//response->htmlpage method?

//should have
//sessionservice
//cookieservice
class BaseController {
	protected $page;
	protected $action;

	public function __construct() {
		$view = new BaseView();
		$this->page = $view->getPage();
		$this->action = $view->getAction();
		// if (isset($_GET['page'])) {
		// 	$this->page = $_GET['page'];
		// } else {
		// 	$this->page = 'index';
		// }
		// if (isset($_GET['action'])) {
		// 	$this->action = $_GET['action'];
		// } else {
		// 	$this->action = 'index';
		// }
			
	}
}
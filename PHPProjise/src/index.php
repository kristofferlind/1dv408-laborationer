<?php

session_set_cookie_params(0);
session_start();

//This is a bit ridiculous, autoloader?
require_once('config/settings.php');
require_once('components/base/base.model.php');
require_once('components/base/base.controller.php');
require_once('components/base/base.view.php');
require_once('components/base/base.dal.php');
require_once('components/authentication/authentication.controller.php');
require_once('components/authentication/authentication.model.php');
require_once('components/response/response.php');
require_once('components/cookie/cookie.service.php');
require_once('components/notify/notify.service.php');
require_once('components/notify/notify.view.php');
require_once('components/notify/notification.php');
require_once('app/account/account.controller.php');
require_once('app/account/account.view.php');
require_once('app/account/account.dal.php');
require_once('app/account/login/account.login.model.php');
require_once('app/account/login/account.login.controller.php');
require_once('app/account/login/account.login.view.php');
require_once('app/account/register/account.register.model.php');
require_once('app/account/register/account.register.controller.php');
require_once('app/account/register/account.register.view.php');
require_once('app/project/project.controller.php');
require_once('app/project/create/project.create.controller.php');
require_once('app/project/create/project.create.view.php');
require_once('app/project/delete/project.delete.controller.php');
require_once('app/project/delete/project.delete.view.php');
require_once('app/project/edit/project.edit.controller.php');
require_once('app/project/edit/project.edit.view.php');
require_once('app/project/list/project.list.controller.php');
require_once('app/project/list/project.list.view.php');

$baseController = new BaseController();


if (isset($_GET['section'])) {
	switch ($_GET['section']) {
		case 'account':
			$controller = new AccountController();
			break;
		case 'project':
			$controller = new ProjectController();
			break;
		// Not implemented yet, structure might change while doing project
		// case 'story':
		// 	$controller = new StoryController();
		// 	break;
		default:
			$controller = new AccountController();
	}
} else {
	$controller = new AccountController();
}

$notify = new Notify();
$notifyView = new NotifyView($notify);
$response = new Response();
$response->HTMLPage($controller->index(), $notifyView);
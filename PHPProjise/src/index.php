<?php

//This is a bit ridiculous, autoloader?
require_once('config/settings.php');
require_once('components/base/base.model.php');
require_once('components/base/base.controller.php');
require_once('components/base/base.view.php');
require_once('components/base/base.dal.php');
require_once('components/authentication/authentication.controller.php');
require_once('components/authentication/authentication.model.php');
require_once('components/authentication/user.php');
require_once('components/authentication/user.dal.php');
require_once('components/response/response.php');
require_once('components/cookie/cookie.service.php');
require_once('components/notify/notify.service.php');
require_once('components/notify/notify.view.php');
require_once('components/notify/notification.php');
require_once('app/account/account.controller.php');
require_once('app/account/account.view.php');
require_once('app/account/login/account.login.model.php');
require_once('app/account/login/account.login.controller.php');
require_once('app/account/login/account.login.view.php');
require_once('app/account/register/account.register.model.php');
require_once('app/account/register/account.register.controller.php');
require_once('app/account/register/account.register.view.php');
require_once('app/project/project.php');
require_once('app/project/project.controller.php');
require_once('app/project/project.model.php');
require_once('app/project/project.dal.php');
require_once('app/project/create/project.create.controller.php');
require_once('app/project/create/project.create.view.php');
require_once('app/project/delete/project.delete.controller.php');
require_once('app/project/delete/project.delete.view.php');
require_once('app/project/edit/project.edit.controller.php');
require_once('app/project/edit/project.edit.view.php');
require_once('app/project/list/project.list.controller.php');
require_once('app/project/list/project.list.view.php');
require_once('app/story/story.controller.php');
require_once('app/story/story.model.php');
require_once('app/story/story.dal.php');
require_once('app/story/story.php');
require_once('app/story/list/story.list.controller.php');
require_once('app/story/list/story.list.view.php');
require_once('app/story/edit/story.edit.controller.php');
require_once('app/story/edit/story.edit.view.php');

session_set_cookie_params(0);
session_start();

$baseController = new BaseController();

if (isset($_GET['section'])) {
	switch ($_GET['section']) {
		case 'account':
			$controller = new AccountController();
			break;
		case 'project':
			$controller = new ProjectController();
			break;
		case 'story':
			$controller = new StoryController();
			break;
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

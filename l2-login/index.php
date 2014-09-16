<?php

//This only works as intended in internet explorer
//js would be an option, but it seems like an odd solution
session_set_cookie_params(0);
session_start();

//Autoloader?
require_once('src/app/account/account.model.php');
require_once('src/app/account/account.controller.php');
require_once('src/app/account/account.view.php');
require_once('src/app/account/account.dal.php');
require_once('src/components/response/response.php');
require_once('src/components/cookie/cookie.service.php');
require_once('src/components/notify/notify.service.php');
require_once('src/components/notify/notification.php');

$cookieService = new CookieService();
$response = new Response();
$notify = new Notify();
$model = new AccountModel($notify);
$view = new AccountView($model, $cookieService);
$controller = new AccountController($model, $view);

$response->HTMLPage($controller->index(), $notify);
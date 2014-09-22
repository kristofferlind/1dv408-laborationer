<?php
ob_start();
define('inlogg_def', 'test'); // get access to constants

require_once(realpath(dirname(__FILE__)."/app/model/loginModel.php" ));
require_once(realpath(dirname(__FILE__)."/app/controller/loginCtrl.php" ));


$dbh = new \model\DatabaseHandler();
$userDAL = new \model\UserDAL($dbh);
$offlineIdentyfierDAL = new \model\OfflineIdentyfierDAL($dbh);
$sessionService = new \model\SessionService();
$loginModel = new \model\LoginModel($sessionService, $userDAL, $offlineIdentyfierDAL);
$loginCtrl = new \Controller\loginCtrl($loginModel);

$html = $loginCtrl->doControll();

echo $html;
ob_end_flush();
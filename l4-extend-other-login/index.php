<?php
ob_start();
define('inlogg_def', 'test'); // get access to constants

require_once(realpath(dirname(__FILE__)."/app/model/loginModel.php" ));
require_once(realpath(dirname(__FILE__)."/app/controller/loginCtrl.php" ));
require_once(realpath(dirname(__FILE__)."/app/model/notifyService.php" ));
require_once(realpath(dirname(__FILE__)."/app/model/notification.php" ));
require_once(realpath(dirname(__FILE__)."/app/view/notifyView.php" ));

$notifyService = new notifyService();
$dbh = new DatabaseHandler();
$userDAL = new UserDAL($dbh);
$offlineIdentyfierDAL = new OfflineIdentyfierDAL($dbh);
$sessionService = new SessionService();
$loginModel = new LoginModel($sessionService, $userDAL, $offlineIdentyfierDAL, $notifyService);
$loginCtrl = new loginCtrl($loginModel);

$html = $loginCtrl->doControll();

echo $html;
ob_end_flush();
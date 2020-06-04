<?php

//configuration
require_once 'libs/Config.php';

$config = Config::singleton();
$config->set('controllerFolder', 'controller/');
$config->set('modelFolder', 'model/');
$config->set('viewFolder', 'view/');

$config->set('dbhost', '');
$config->set('dbname', '');
$config->set('dbuser', '');
$config->set('dbpass', '');

?>

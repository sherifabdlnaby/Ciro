<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('CONFIG_PATH', ROOT.DS.'config');
define('LIBRARY_PATH', ROOT.DS.'lib');
define('MODEL_PATH', ROOT.DS.'models');
define('VIEW_PATH', ROOT.DS.'views');
define('CONTROLLER_PATH', ROOT.DS.'controllers');
define('LAYOUT_VIEW_PATH', VIEW_PATH.DS.'_layouts');
define('ERROR_VIEW_PATH', VIEW_PATH.DS.'_errors');
define('ALERT_VIEW_PATH', VIEW_PATH.DS.'_alerts');

//TODO Update Bootstrap
//TODO Include CSS/JS
//TODO Custom Layouts
//TODO Session Alert Messages
//TODO APIs routing
//TODO Custom routing

//INITIALIZE
require_once(ROOT.DS.'lib'.DS.'init.php');

try {
    App::run($_SERVER["REQUEST_URI"]);
}
catch(Exception $e)
{
    print_r("EXCEPTION FROM INDEX: ".$e -> getMessage());
}


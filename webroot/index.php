<?php

use Framework6800\Core\App;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('CONFIG_PATH', ROOT.DS.'Config');
define('CORE_PATH', ROOT.DS.'Core');
define('MODEL_PATH', ROOT.DS.'Models');
define('VIEW_PATH', ROOT.DS.'Views');
define('CONTROLLER_PATH', ROOT.DS.'Controllers');
define('LAYOUT_VIEW_PATH', VIEW_PATH.DS.'_Layouts');
define('ERROR_VIEW_PATH', VIEW_PATH.DS.'_Full_Errors');

//INITIALIZE
require_once(CORE_PATH.DS.'init.php');

try {
    App::run($_SERVER["REQUEST_URI"]);
}
catch(Exception $e)
{
    print_r("EXCEPTION : ".$e -> getMessage());
}


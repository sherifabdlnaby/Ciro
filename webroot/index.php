<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VIEW_PATH', ROOT.DS.'views');

//INITIALIZE
require_once(ROOT.DS.'lib'.DS.'init.php');

try {
    App::run($_SERVER["REQUEST_URI"]);
}
catch(Exception $e)
{
    print_r("EXCEPTION FROM INDEX: ".$e -> getMessage());
}


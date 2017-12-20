<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VIEW_PATH', ROOT.DS.'views');

//INITIALIZE
require_once(ROOT.DS.'lib'.DS.'init.php');

$collection = Database::getCollection("Users");

$doc = array(
    "name" => "MOMO",
    "reg" => "xxx"
);

$collection -> insert($doc);


try {
    App::run($_SERVER["REQUEST_URI"]);
}
catch(Exception $e)
{
    print_r("EXCEPTION FROM INDEX: ".$e -> getMessage());
}


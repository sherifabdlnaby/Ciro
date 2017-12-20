<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

//INITIALIZE
require_once(ROOT.DS.'lib'.DS.'init.php');

$router = new Router($_SERVER["REQUEST_URI"]);
echo "<pre>" ;
print_r('Routes: '.$router -> getRoute().PHP_EOL);
print_r('Controller: '.$router -> getController().PHP_EOL);
print_r('Action: '.$router -> getRoutePrefix().$router->getAction().PHP_EOL);
echo "Params: ";
print_r($router ->getParams());


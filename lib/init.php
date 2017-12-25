<?php

//Init Config
require_once(CONFIG_PATH.DS.'config.php');

//Init DB
require_once(CONFIG_PATH.DS.'mongo.php');

//Start or Resume Session
session_start();

/**
 * @param $class_name
 * @throws Exception
 * @description This Function runs automatically whenever a class is called, and it require_once() it using our directory rules.
 */
function __autoload($class_name){
    $libPath = LIBRARY_PATH.DS.strtolower($class_name).'.class.php';
    $controllerPath = CONTROLLER_PATH.DS.str_replace('controller', '', strtolower($class_name)).'.controller.php';
    $modelPath = MODEL_PATH.DS.strtolower($class_name).'.class.php';
    if(file_exists($libPath))
        require_once($libPath);
    if (file_exists($controllerPath))
        require_once($controllerPath);
    if (file_exists($modelPath))
        require_once($modelPath);
}

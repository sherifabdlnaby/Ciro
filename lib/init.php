<?php

require_once(ROOT.DS.'config'.DS.'config.php');

/**
 * @param $class_name
 * @throws Exception
 * @description This Function runs automatically whenever a class is called, and it require it using our logic.
 */
function __autoload($class_name){
    $libPath = ROOT.DS.'lib'.DS.strtolower($class_name).'.class.php';
    //Remove Controller from class name by str_replace
    $controllerPath = ROOT.DS.'controllers'.DS.str_replace('controller', '', strtolower($class_name)).'.controllers.php';
    $modelPath = ROOT.DS.'lib'.DS.strtolower($class_name).'.class.php';
    if(file_exists($libPath))
        require_once($libPath);
    elseif (file_exists($controllerPath))
        require_once($controllerPath);
    elseif (file_exists($modelPath))
        require_once($modelPath);
    else
        throw new Exception("Failed to Include ".$class_name." . Invalid Name, or Not Found.");
}

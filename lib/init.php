<?php

//Init Config
require_once(CONFIG_PATH.DS.'config.php');

//Init Routing
require_once(CONFIG_PATH.DS.'routes.php');

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
    $modelPath = MODEL_PATH.DS.strtolower($class_name).'.class.php';

    //Include Lib Classes (Unique Class Names, hence return if found).
    if(file_exists($libPath)){
        require_once($libPath);
        return;
    }

    //Include Model Classes
    if (file_exists($modelPath))
        require_once($modelPath);

    //Search in all Controllers Directories
    $subDirectories = scandir(CONTROLLER_PATH);
    $controllerClassName = str_replace('controller', '', strtolower($class_name));
    foreach ($subDirectories as $subDirectory)
    {
        //Ignore Parent Directories.
        if($subDirectory == '.' || $subDirectory =='..')
            continue;

        //Create Full Path
        $ControllerPath = CONTROLLER_PATH.DS.$subDirectory.DS.$controllerClassName.'.controller.php';

        //Include if exits
        if (file_exists($ControllerPath))
        {
            require_once($ControllerPath);
            return;
        }
    }
}

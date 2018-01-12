<?php

//Init Config
require_once(CONFIG_PATH.DS.'config.php');

//Init MySQL if enabled.
if(Config::get('use_mysql_db') === true)
    require_once(CONFIG_PATH.DS.'mysql.php');

//Init MongoDB if enabled
if(Config::get('use_mysql_db') === true)
    require_once(CONFIG_PATH.DS.'mongo.php');

//Init Routing
if(Config::get('use_custom_routes') === true)
    require_once(CONFIG_PATH.DS.'routes.php');

//Start or Resume Session if global Session enabled
if(Config::get('use_global_session') === true)
    session_start();

/**
 * @param $class_name
 * @description This Function runs automatically whenever a class is called, and it require_once() it using our directory rules.
 */
//TODO Make it COMPOSER compatible
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

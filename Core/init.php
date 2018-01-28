<?php

use App\Core\Config;
use App\Core\ExceptionHandler;

//Composer Autoload using PSR-4
require_once (ROOT.DS.'Vendor/autoload.php');

//Init Config
require_once(CONFIG_PATH.DS.'config.php');

//Init MySQLi if enabled.
if(Config::get('use_mysqli_db') === true)
    require_once(CONFIG_PATH . DS . 'mysqli.php');

//Init PDO if enabled.
if(Config::get('use_pdo_db') === true)
    require_once(CONFIG_PATH.DS.'pdo.php');

//Init MongoDB if enabled
if(Config::get('use_mongo_db') === true)
    require_once(CONFIG_PATH.DS.'mongo.php');

//Init Routing
if(Config::get('use_custom_routes') === true)
    require_once(CONFIG_PATH.DS.'routes.php');

//Start or Resume Session if global Session enabled
if(Config::get('use_global_session') === true)
    session_start();

//Start or Resume Session if global Session enabled
if(Config::get('use_exception_handler') === true)
    ExceptionHandler::enableExceptionHandler();

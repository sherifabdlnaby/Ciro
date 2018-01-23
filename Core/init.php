<?php

use App\Core\Config;

//Composer Autoload using PSR-4
require_once (ROOT.DS.'Vendor/autoload.php');

//Init Config
require_once(CONFIG_PATH.DS.'Config.php');

//Init MySQLi if enabled.
if(Config::get('use_mysql_db') === true)
    require_once(CONFIG_PATH.DS.'Mysql.php');

//Init PDO if enabled.
if(Config::get('use_pdo_db') === true)
    require_once(CONFIG_PATH.DS.'Pdo.php');

//Init MongoDB if enabled
if(Config::get('use_mongo_db') === true)
    require_once(CONFIG_PATH.DS.'Mongo.php');

//Init Routing
if(Config::get('use_custom_routes') === true)
    require_once(CONFIG_PATH.DS.'Routes.php');

//Start or Resume Session if global Session enabled
if(Config::get('use_global_session') === true)
    session_start();
<?php

use App\Core\App;

define('DS',    DIRECTORY_SEPARATOR);
define('ROOT',  dirname(dirname(__FILE__)));
define('CONFIG_PATH',   ROOT.DS.'Config');
define('CORE_PATH',     ROOT.DS.'Core');
define('MODEL_PATH',    ROOT.DS.'Models');
define('VIEW_PATH',     ROOT.DS.'Views');
define('LOG_PATH',      ROOT.DS.'Logs');
define('CONTROLLER_PATH',   ROOT.DS.'Controllers');
define('LAYOUT_VIEW_PATH',  VIEW_PATH.DS.'_Layouts');
define('MESSAGE_VIEW_PATH', '_FullMessages');

//INITIALIZE
require_once(CORE_PATH.DS.'init.php');

//RUN
App::run($_SERVER["REQUEST_URI"]);
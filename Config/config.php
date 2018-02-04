<?php
use App\Core\Config;

/* Names, constants, and stuff that will be used in the code later. */
Config::set('title', 'Ciro');

/* Optional Settings (Flags) */

/* Loads mysqli configurations set at Config/mysqli.php  */
Config::set('use_mysqli_db', true);
/* Loads MongoDB configurations set at Config/pdo.php  */
Config::set('use_pdo_db', true);
/* Loads MongoDB configurations set at Config/mongo.php  */
Config::set('use_mongo_db', true);
/* Enable custom routes, any uri that matches routes set at Config/routes.php will be routed accordingly */
Config::set('use_custom_routes', true);
/* Start Session at start of every script. */
Config::set('use_global_session', true);
/* Handle Exceptions and Errors */
Config::set('use_exception_handler', true);
/* Logs exceptions and errors if exception handler is used  */
Config::set('log_exceptions_errors', false);
/* Exception Handler Logs file destination to be used if logging exceptions & errors is enabled. */
Config::set('exception_handler_log_destination', LOG_PATH.DS.'exception_handler_log.log');
/* Default layout used for views if no specific layout mentioned. */
Config::set('default_layout', 'default');

/* Routing defaults
 * -> Web route must match a route defined at routes table below. */
Config::set('default_route', 'Web');
Config::set('default_controller', 'Home');
Config::set('default_action', 'Index');

/*  Routes Table
    Description:
    -   Controllers of the route should be included in the /Controllers/{Route Name} directory.
    -   Views of Route Controller should be included in the /Views/{Route Name}/{Controller}/ directory.
*/
Config::set('routes', array(
    //  Route Name
    'Web','Api', 'Admin'
));
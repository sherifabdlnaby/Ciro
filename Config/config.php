<?php
use App\Core\Config;

/* Names, constants, and stuff that will be used in the code later. */
Config::set('site_name', 'PHP Framework');

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
/* Handle Exceptions and Errors, optionally logs them, catch errors and throw them as an ErrorException.
   Also Prints a 500 : Internal Server error custom error page for the user. */
Config::set('use_exception_handler', true);
/* log exceptions and errors if exception handler is used  */
Config::set('log_exceptions_errors', true);
/* Exception Handler log file destination to be used if logging exceptions & errors is enabled.
 (beware not to put log file in Webroot/ public directory, always use ROOT constant as a base) */
Config::set('exception_handler_log_destination', ROOT.DS.'exception_handler_log.log');
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
    -   Controllers class name of a route should be pre-fixed with the route pre-fix value.
        e.g ( Controllers of route X should have name : { X => prefix value}{Controller Name}Controller )
*/
Config::set('routes', array(
//  Route Name  |   Route Prefix
    'Web'       => '',
    'Api'       => 'API_',
    'Admin'     => 'Admin_'
));
<?php
/* Names, constants, and stuff. */
Config::set('site_name', 'PHP Framework');

/* Optional Settings */
Config::set('use_mysql_db', true);
Config::set('use_mongo_db', true);
Config::set('use_custom_routes', true);
Config::set('use_global_session', true);    // <-- Start Session at start of every script.


/* Default layout used for views if no specific layout mentioned. */
Config::set('default_layout', 'default');


/* Routing defaults
 * -> default route must match a route defined at routes table below. */
Config::set('default_route', 'default');
Config::set('default_controller', 'home');
Config::set('default_action', 'index');

/*  Routes Table
    Description:
    -   Controllers of the route should be included in the /Controllers/{Route Name} directory.
    -   Views of Route Controller should be included in the /Views/{Route Name}/{Controller}/ directory.
    -   Controllers class name of a route should be pre-fixed with the route pre-fix value.
        e.g ( controllers of route X should have name : { X => prefix value}{Controller Name}Controller )
*/
Config::set('routes', array(
//  Route Name  |   Route Prefix
    'default'   => '',
    'api'       => 'API_',
    'admin'     => 'Admin_'
));
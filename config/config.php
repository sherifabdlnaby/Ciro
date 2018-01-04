<?php
//Names and stuff
Config::set('site_name', 'PHP Framework');

//Routing defaults
Config::set('default_route', 'default');        //default route must match a route defined at routes table below.
Config::set('default_controller', 'home');
Config::set('default_action', 'index');

//Layout defaults
Config::set('default_layout', 'default');

//  Routes Table
/*  Description:
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

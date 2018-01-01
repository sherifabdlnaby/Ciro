<?php
//Names and stuff
Config::set('site_name', 'Valley');

//Routing defaults
Config::set('default_route', 'default');        //default route must match a route defined at routes table below.
Config::set('default_controller', 'home');
Config::set('default_action', 'index');

//Layout defaults
Config::set('default_layout', 'default');

//Routes Table
/*Controllers of Route should be post-fixed with the route value
/*e.g( 'api' route matches -> Name'_Api'Controller, 'default'route -> Name''Controller -> HomeController)
*/
Config::set('routes', array(
    'default' => '',
    'api' => '_Api',
    'admin' => '_Admin'
));
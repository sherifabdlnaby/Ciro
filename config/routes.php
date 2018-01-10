<?php

/*
 * - Route Parameters should be surrounded by '{  }', e.g( {name} ).
 * - Route Parameters will be passed to the Controller's action parameters ordered respectively
 *      e.g(  1st Route params will be passed to 1st , and 2nd to 2nd, and so on...' )
 * - Optional Route parameters must have a '?' appended at the end of parameter name, e.g( {name?} ).
 * - Once an optional parameter is used, all subsequent parameters must be optional too.
 * - Optional parameters must have a default value in it's corresponding controller's action parameters.
 * - Example:
 *      Route::X('custom/route/{id}/{name}/{language?}','default', 'home', 'CustomRouteOne');
 *      This Route Correspond to the action 'CustomRouteOne' in the controller 'Home', which belongs to the route 'default'
 *      The CustomRouteOne function signature should be 'public function CustomRouteOne($id, $name, language = 'English')'
*/

Route::set('custom/route/{id}/of/{name}/blabla/{desc?}','default', 'home', 'CustomRouteOne');
Route::set('custom/route/blank/{id?}','default', 'home', 'CustomRouteTwo');
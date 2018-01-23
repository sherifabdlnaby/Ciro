<?php
use App\Core\Route;

/*
 * - Route Parameters should be surrounded by '{  }', e.g( {name} ).
 * - Route Parameters will be passed to the Controller's action parameters ordered respectively
 *      e.g(  1st Route params will be passed to 1st , and 2nd to 2nd, and so on...' )
 * - Optional Route parameters must have a '?' appended at the end of parameter name, e.g( {name?} ).
 * - Once an optional parameter is used, all subsequent parameters must be optional too.
 * - Optional parameters must have a Web value in it's corresponding controller's action parameters.
 * - Example:
 *      Route::X('custom/route/{id}/{name}/{language?}','Web', 'home', 'CustomRouteOne');
 *      This Route Correspond to the action 'CustomRouteOne' in the controller 'Home', which belongs to the route 'Web'
 *      The CustomRouteOne function signature should be 'public function CustomRouteOne($id, $name, language = 'English')'
 *
 * - Throws an Exception if Custom Route doesn't match an existing Route, Controller, and Action.
 * - Route::Get/Post/Put/Patch/Delete/Options routes if REQUEST_METHOD matches. Route::All routes regardless of REQUEST_METHOD.
*/


//Route::All('Account/{username}','Web', 'Account', 'View');
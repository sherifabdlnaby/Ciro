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
 *      Route::X('custom/route/{id}/{name}/{language?}','Web', 'home', 'CustomRouteAction');
 *      This Route Correspond to the action 'CustomRouteAction' in the controller 'Home', which belongs to the route 'Web'
 *      The CustomRouteOne function signature should be 'public function CustomRouteAction($id, $name, language = 'defaultLanguage')'
 *
 *      Route::X('{route}/{controller}/{action}/{param1}/{param2?}','{route}', '{controller}', '{action}');
 *      if url = '****.com/web/product/view/productUsername/optionalSortParam'
 *      then this Route Correspond to the action 'view' in the controller 'product' which belongs to the route 'web' and will
 *      pass productUsername and optionalSortParam to Product::View($productUsername, $optionalSortParam), notice that variables
 *      like {controller} and {action} will not be passed as params.
 *      The view function signature should be " public function View($productUsername, $optionalSortParam = 'defaultValue') "


 *
 * - Route::Get/Post/Put/Patch/Delete/Options routes if REQUEST_METHOD matches. Route::All routes regardless of REQUEST_METHOD.
*/

/* A Route Example (Notice variable argument ( {} ) in controller and action ) */
// Route::get('Account/{username}','Web', 'Account', 'View');

/* A Route Example with Variable argument (Notice variable argument ( {} ) in controller and action ) */
// Route::all('Web/{controller}/{action}/{param}','Web', '{controller}', '{action}');
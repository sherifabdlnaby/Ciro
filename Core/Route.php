<?php

namespace App\Core;

class Route
{
    protected static $GetRoutes = array();
    protected static $PostRoutes = array();
    protected static $PutRoutes = array();
    protected static $PatchRoutes = array();
    protected static $DeleteRoutes = array();
    protected static $OptionsRoutes = array();
    protected static $AllRoutes = array();

    /**
     * match path parts with all registered custom routes according to REQUEST_METHOD
     * return parsed attributes if matched, false otherwise.
     * @param $path_parts (URI exploded by '/')
     * @return false | array , false if not matched | routeAttributes array() if matched.
     */
    public static function CustomRouteMatch(&$path_parts)
    {
        $routeAttributes = false;

        if ($_SERVER['REQUEST_METHOD'] === 'GET')
            $routeAttributes = Route::routeMatch($path_parts, Route::$GetRoutes);
        else if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $routeAttributes = Route::routeMatch($path_parts, Route::$PostRoutes);
        else if ($_SERVER['REQUEST_METHOD'] === 'PUT')
            $routeAttributes = Route::routeMatch($path_parts, Route::$PutRoutes);
        else if ($_SERVER['REQUEST_METHOD'] === 'PATCH')
            $routeAttributes = Route::routeMatch($path_parts, Route::$PatchRoutes);
        else if ($_SERVER['REQUEST_METHOD'] === 'DELETE')
            $routeAttributes = Route::routeMatch($path_parts, Route::$DeleteRoutes);
        else if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS')
            $routeAttributes = Route::routeMatch($path_parts, Route::$OptionsRoutes);

        //If routeAttributes === false -> check $AllRoutes.
        if ($routeAttributes === false)
            $routeAttributes = Route::routeMatch($path_parts, Route::$AllRoutes);

        return $routeAttributes;
    }

    /**
     * match path parts with all registered custom routes, return parsed attributes if matched, false otherwise.
     * @param $path_parts (URI exploded by '/')
     * @param $routes
     * @return false | mixed false if not matched | routeAttributes array() if matched.
     */
    private static function routeMatch(&$path_parts, &$routes)
    {
        foreach ($routes as $route => $routeAttributes) {
            //--Compare Matching Pattern--

            //Explode to parts
            $route_parts = explode('/', $route);

            //Escape this route if it is less than current path.
            if (count($path_parts) > count($route_parts))
                continue;

            //Start Matching
            $matching = true;
            foreach ($route_parts as $i => $route_part) {
                //Check if a parameter .../{xxx}/....
                if (self::isRouteVar($route_part)) {
                    //if no longer parts in path -> if optional param -> continue, else, it doesn't match -> break;
                    if ($i >= count($path_parts)) {
                        if ($route_part[strlen($route_part) - 2] === '?')
                            continue;
                        else {
                            $matching = false;
                            break;
                        }
                    }
                }
                //1st condition -> Reaching here and having i >= path parts therefore doesn't match, hence break;.
                //2nd condition -> Reaching here and having $route_part not equal $path_parts[i] therefore doesn't match, hence break;.
                else if ($i >= count($path_parts) || strcasecmp($route_part, $path_parts[$i]) != 0) {
                    $matching = false;
                    break;
                }
            }

            //If above for-loop yielded a matching route, extract attributes and add params -> return.
            if ($matching === true) {

                $params = array();

                foreach ($route_parts as $i => &$part)
                {
                    if( self::isRouteVar($part) && $i < count($path_parts) ) {
                        if ($part === $routeAttributes['route'])
                            $routeAttributes['route'] = $path_parts[$i];
                        elseif ($part === $routeAttributes['controller'])
                            $routeAttributes['controller'] = $path_parts[$i];
                        elseif ($part === $routeAttributes['action'])
                            $routeAttributes['action'] = $path_parts[$i];
                        else
                            array_push($params, $path_parts[$i]);
                    }
                }

                //Add Params
                $routeAttributes['params'] = $params;

                return $routeAttributes;
            }
        }
        return false;
    }

    /**
     * routes the given $uri to the specified route / controller / action to all the GET requests.
     * @param $uri
     * @param $route
     * @param $controller
     * @param $action
     */
    public static function get($uri, $route, $controller, $action)
    {
        self::$GetRoutes[$uri] = array(
            'route' => $route,
            'controller' => $controller,
            'action' => $action);
    }

    /**
     * routes the given $uri to the specified route / controller / action to all the POST requests.
     * @param $uri
     * @param $route
     * @param $controller
     * @param $action
     */
    public static function post($uri, $route, $controller, $action)
    {
        self::$PostRoutes[$uri] = array(
            'route' => $route,
            'controller' => $controller,
            'action' => $action);
    }

    /**
     * routes the given $uri to the specified route / controller / action to all the PUT requests.
     * @param $uri
     * @param $route
     * @param $controller
     * @param $action
     */
    public static function put($uri, $route, $controller, $action)
    {
        self::$PutRoutes[$uri] = array(
            'route' => $route,
            'controller' => $controller,
            'action' => $action);
    }

    /**
     * routes the given $uri to the specified route / controller / action to all the PATCH requests.
     * @param $uri
     * @param $route
     * @param $controller
     * @param $action
     */
    public static function patch($uri, $route, $controller, $action)
    {
        self::$PatchRoutes[$uri] = array(
            'route' => $route,
            'controller' => $controller,
            'action' => $action);
    }

    /**
     * routes the given $uri to the specified route / controller / action to all the DELETE requests.
     * @param $uri
     * @param $route
     * @param $controller
     * @param $action
     */
    public static function delete($uri, $route, $controller, $action)
    {
        self::$DeleteRoutes[$uri] = array(
            'route' => $route,
            'controller' => $controller,
            'action' => $action);
    }

    /**
     * routes the given $uri to the specified route / controller / action to all the OPTIONS requests.
     * @param $uri
     * @param $route
     * @param $controller
     * @param $action
     */
    public static function options($uri, $route, $controller, $action)
    {
        self::$OptionsRoutes[$uri] = array(
            'route' => $route,
            'controller' => $controller,
            'action' => $action);
    }

    /**
     * routes the given $uri to the specified route / controller / action to all requests.
     * @param $uri
     * @param $route
     * @param $controller
     * @param $action
     */
    public static function all($uri, $route, $controller, $action)
    {
        self::$AllRoutes[$uri] = array(
            'route' => $route,
            'controller' => $controller,
            'action' => $action);
    }

    /**
     * Check if $part is a Route Variable(has {})
     * @param $part
     * @return bool
     */
    private static function isRouteVar($part)
    {
        return strlen($part) > 1 && $part[0] === '{' && $part[strlen($part) - 1] === '}';
    }
}
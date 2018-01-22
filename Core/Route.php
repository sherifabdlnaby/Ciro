<?php

namespace Framework6800\Core;

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
     * @return false if not matched | routeAttributes array() if matched.
     */
    public static function CustomRouteMatch(&$path_parts)
    {
        $routeAttributes = false;

        if($_SERVER['REQUEST_METHOD'] === 'GET')
            $routeAttributes = Route::routeMatch($path_parts, Route::$GetRoutes);
        else if($_SERVER['REQUEST_METHOD'] === 'POST')
            $routeAttributes = Route::routeMatch($path_parts, Route::$PostRoutes);
        else if($_SERVER['REQUEST_METHOD'] === 'PUT')
            $routeAttributes = Route::routeMatch($path_parts, Route::$PutRoutes);
        else if($_SERVER['REQUEST_METHOD'] === 'PATCH')
            $routeAttributes = Route::routeMatch($path_parts, Route::$PatchRoutes);
        else if($_SERVER['REQUEST_METHOD'] === 'DELETE')
            $routeAttributes = Route::routeMatch($path_parts, Route::$DeleteRoutes);
        else if($_SERVER['REQUEST_METHOD'] === 'OPTIONS')
            $routeAttributes = Route::routeMatch($path_parts, Route::$OptionsRoutes);

        //If routeAttributes === false -> check $AllRoutes.
        if($routeAttributes === false)
            $routeAttributes = Route::routeMatch($path_parts, Route::$AllRoutes);

        return $routeAttributes;
    }

    /**
     * match path parts with all registered custom routes, return parsed attributes if matched, false otherwise.
     * @param $path_parts (URI exploded by '/')
     * @param $routes
     * @return false if not matched | routeAttributes array() if matched.
     */
    public static function routeMatch(&$path_parts, &$routes)
    {
        foreach ($routes as $route => $routeAttributes) {
            //--Compare Matching Pattern--

            //Explode to parts
            $route_parts = explode('/', $route);

            //Escape this route if it is less than current path.
            if(count($path_parts) > count($route_parts))
                continue;

            //Start Matching
            $i = 0;
            $matching = true;
            $params = array();
            foreach ($route_parts as $route_part) {
                //Check if a parameter .../{xxx}/....
                if ($route_part[0] === '{' && $route_part[strlen($route_part) - 1] === '}') {
                    //if no longer parts in path -> if optional param -> continue, else, it doesn't match -> break;
                    if ($i >= count($path_parts)) {
                        if ($route_part[strlen($route_part) - 2] === '?')
                            continue;
                        else {
                            $matching = false;
                            break;
                        }
                    }
                    //Collect Params
                    array_push($params, $path_parts[$i]);
                }
                //1st condition -> Reaching here and having i >= path parts therefore doesn't match, hence break;.
                //2nd condition -> Reaching here and having $route_part not equal $path_parts[i] therefore doesn't match, hence break;.
                else if ($i >= count($path_parts) || strcasecmp($route_part, $path_parts[$i]) != 0) {
                    $matching = false;
                    break;
                }

                //Increment Path Iterator
                ++$i;
            }

            //If above for-loop yielded a matching route, extract attributes and add params -> return.
            if ($matching === true) {
                $routeAttributes['params'] = $params;
                return $routeAttributes;
            }

        }
        return false;
    }

    public static function Get($key, $route, $controller, $action)
    {
        self::$GetRoutes[$key] = array(
            'route' => $route,
            'controller' => $controller,
            'action' => $action);
    }

    public static function Post($key, $route, $controller, $action)
    {
        self::$PostRoutes[$key] = array(
            'route' => $route,
            'controller' => $controller,
            'action' => $action);
    }

    public static function Put($key, $route, $controller, $action)
    {
        self::$PutRoutes[$key] = array(
            'route' => $route,
            'controller' => $controller,
            'action' => $action);
    }

    public static function Patch($key, $route, $controller, $action)
    {
        self::$PatchRoutes[$key] = array(
            'route' => $route,
            'controller' => $controller,
            'action' => $action);
    }

    public static function Delete($key, $route, $controller, $action)
    {
        self::$DeleteRoutes[$key] = array(
            'route' => $route,
            'controller' => $controller,
            'action' => $action);
    }

    public static function Options($key, $route, $controller, $action)
    {
        self::$OptionsRoutes[$key] = array(
            'route' => $route,
            'controller' => $controller,
            'action' => $action);
    }

    public static function All($key, $route, $controller, $action)
    {
        self::$AllRoutes[$key] = array(
            'route' => $route,
            'controller' => $controller,
            'action' => $action);
    }
}
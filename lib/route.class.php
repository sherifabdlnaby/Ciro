<?php

class Route
{
    protected static $routes = array();

    public static function get($key)
    {
        return isset(self::$routes[$key]) ? self::$routes[$key] : null;
    }

    public static function set($key, $route, $controller, $action)
    {
        self::$routes[$key] = array('route' => $route,
            'controller' => $controller,
            'action' => $action);
    }

    public static function routeMatch($path_parts)
    {
        foreach (self::$routes as $route => $routeAttributes) {
            //--Compare Matching Pattern--

            //Explode to parts
            $route_parts = explode('/', $route);

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
}
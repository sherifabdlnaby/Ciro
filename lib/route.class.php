<?php

class Route{
    protected static $routes = array();

    public static function get($key){
        return isset(self::$routes[$key]) ? self::$routes[$key] : null;
    }

    public static function set($key, $route ,$controller, $action){
        self::$routes[$key] = array('route' => $route,
                                    'controller' => $controller,
                                    'action' => $action);
    }

    public static function routeMatch($path_parts)
    {
        foreach (self::$routes as $route => $routeAttributes)
        {
            //Compare Matching Pattern
            $route_parts = explode('/', $route);
            $matching = true;
            $i = 0;
            foreach ($route_parts as $route_part) {
                //Check if a parameter .../{xxx}/....
                if ($route_part[0] === '{' && $route_part[strlen($route_part) - 1] === '}') {
                    $numb = 123;
                }

                //Check if uri part is equal to route part;
                else if (strcasecmp($route_part, $path_parts[$i]) != 0){
                    $matching = false;
                    break;
                }

                //Increment Path Iterator
                ++$i;
            }
            if($matching === true)
                return $matching;
        }
        return false;
    }
}
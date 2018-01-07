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

            //Explode to parts
            $route_parts = explode('/', $route);

            ///Escape this custom route earlier if it's count > current uri parts count (will always be false)
            ///Won't escape If current uri parts count > custom route in-case of using slangs in the url.
            if(count($route_parts) > count($path_parts))
                continue;

            //Start Matching
            $i = 0; $matching = true;
            $params = array();
            foreach ($route_parts as $route_part) {
                //Check if a parameter .../{xxx}/....
                if ($route_part[0] === '{' && $route_part[strlen($route_part) - 1] === '}') {
                    //Collect Params
                    array_push($params, $path_parts[$i]);
                }

                //Check if uri part is equal to route part;
                else if (strcasecmp($route_part, $path_parts[$i]) != 0){
                    $matching = false;
                    break;
                }

                //Increment Path Iterator
                ++$i;
            }
            if($matching === true){
                $routeAttributes['params'] = $params;
                return $routeAttributes;
            }
        }
        return false;
    }
}
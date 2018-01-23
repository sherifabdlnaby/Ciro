<?php

namespace App\Core;

class App{
    protected static $router;

    /**
     * @param $uri
     * @throws \Exception
     */
    public static function run(&$uri)
    {
        //Create a router  object (constructor resolves uri)
        self::$router = new router($uri);
        //ClassName = RoutePrefix + Url Controller + 'Controller'
        $bareClassName = self::$router->getRoutePrefix().self::$router->getController().'Controller';
        //Add Name space to have a fully qualified Controller Class name.
        $controllerClass = '\\App\\Controllers\\'.self::$router -> getRoute().'\\'.$bareClassName;
        //Controller's Method to be called
        $controllerMethod = self::$router->getAction();

        //Create New Controller Object from variable (Yeay PHP stuff :'D)
        $controllerObject = null;
        if(class_exists($controllerClass))
            $controllerObject = new $controllerClass();

        //Check if Controller and Action Exists in our code
        if(method_exists($controllerObject, $controllerMethod)) {
            //RUN Controller
            $controllerOutput = call_user_func_array(array($controllerObject, $controllerMethod), self::$router -> getParams());
            //echo Controller's output (This is our final result)
            echo $controllerOutput;
            //Exit Script.
            exit();
        }

        /* REACHING HERE means -> Routing Failed. */

        /* If Failed to be Routed via a Custom Route, throw exception
         (It's developer's responsibility to route custom routes to correct Controller and Method.). */
        if(self::$router->isCustomRoute())
            throw new \Exception("Route handled by Custom Route failed, Can't find Action: '".self::$router->getAction()."', Controller: '".self::$router->getController()."', Route: '".self::$router->getRoute()."'. Please check route parameters at route.php.");

        /* If Routed via Default Route (User entering incorrect URL)
           (SEND 404 NOT FOUND Web-page {WEB}) */
        $controllerObject = new WebController();
        $controllerOutput = $controllerObject -> renderFullError('Page Not Found', 404);
        echo $controllerOutput;
        exit();
    }

    /**
     * @return mixed
     */
    public static function getRouter()
    {
        return self::$router;
    }

}
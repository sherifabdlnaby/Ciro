<?php

namespace App\Core;

class App{
    protected static $router;

    /**
     * @param $uri
     */
    public static function run(&$uri)
    {
        //Create a router  object (constructor resolves uri)
        self::$router = new Router($uri);
        //ClassName = RoutePrefix + Url Controller + 'Controller'
        $bareClassName = self::$router->getController().'Controller';
        //Add Name space to have a fully qualified Controller Class name.
        $controllerClass = '\\App\\Controllers\\'.self::$router -> getRoute().'\\'.$bareClassName;
        //Controller's Method to be called
        $controllerMethod = self::$router->getAction();

        //Create New Controller Object from variable (Yeay PHP stuff :'D)
        $controllerObject = null;
        if(class_exists($controllerClass))
            $controllerObject = new $controllerClass();

        //Check if Controller and Action Exists in our code
        if(method_exists($controllerObject, $controllerMethod))
              /* RUN Controller */
            $controllerOutput = $controllerObject -> $controllerMethod(...self::$router -> getParams());
        else  /* REACHING HERE means -> Routing Failed. Output full Error and send status code 404 */
            $controllerOutput = self::renderFullError("Can't Resolve URL", 404);

        //echo Controller's output (This is our final result)
        echo $controllerOutput;

        //Exit Script.
        exit();
    }

    /**
     * @return mixed
     */
    public static function getRouter()
    {
        return self::$router;
    }

    /**
     * a Wrapper function to render an error Page.
     * @param $message
     * @param $errorStatusCode
     * @param $layout
     * @return string
     */
    public static function renderFullError($message, $errorStatusCode = null, $layout = null){
        $controllerObject = new WebController();
        return $controllerObject -> renderFullError($message, $errorStatusCode, $layout);
    }

}
<?php

class App{
    protected static $router;

    public static function run($uri)
    {
        self::$router = new router($uri);

        //ClassName = Url Controller + Route Prefix + 'Controller'
        $bareClassName = self::$router -> getRoutePrefix().self::$router->getController();
        $controllerClass = $bareClassName."Controller";
        $controllerMethod = self::$router->getAction();

        //Create New Controller Object from variable (Yeay PHP stuff :'D)
        $controllerObject = null;
        if(class_exists($controllerClass))
            $controllerObject = new $controllerClass();

        //Check if Controller and Action Exists in our code
        if(method_exists($controllerObject, $controllerMethod)) {
            //RUN Controller
            $controllerOutput = $controllerObject->$controllerMethod();
            //echo Controller's output
            echo $controllerOutput;
            //Exit Script.
            exit();
        }

        //SEND 404 NOT FOUND
        $controllerObject = new Controller();
        $controllerOutput = $controllerObject -> renderFullError(404);
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
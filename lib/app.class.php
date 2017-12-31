<?php

class App{
    protected static $router;

    /**
     * @return mixed
     */
    public static function getRouter()
    {
        return self::$router;
    }

    public static function run($uri)
    {
        self::$router = new router($uri);

        $controllerClass = ucfirst(self::$router->getController()).self::$router -> getRoutePrefix()."Controller";
        $controllerMethod = ucfirst(self::$router->getAction());

        //Create New Controller Object from variable (Yeay PHP stuff :'D)
        $controllerObject = null;
        if(class_exists($controllerClass))
            $controllerObject = new $controllerClass();

        //Check if Controller and Action Exists in our code
        if(method_exists($controllerObject, $controllerMethod)) {
            //RUN Controller
            $controllerOutput = $controllerObject->$controllerMethod();
            echo $controllerOutput;
            exit();
        }

        //SEND 404
        $controllerObject = new Controller();
        $controllerOutput = $controllerObject -> renderFullError(404);
        echo $controllerOutput;
        exit();
    }
}
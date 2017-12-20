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

        $controllerClass = ucfirst(self::$router->getController())."Controller";
        $controllerMethod = ucfirst(self::$router->getRoutePrefix() . self::$router->getAction());

        //Create New Controller Object from variable (Yeay PHP stuff :'D)
        $controllerObject = null;
        if(class_exists($controllerClass))
            $controllerObject = new $controllerClass();

        //Check if Controller and Action Exists in our code
        if(method_exists($controllerObject, $controllerMethod))
            //RUN
            $controllerObject -> $controllerMethod();
        else
            throw new Exception('Method: "'.$controllerMethod.'" or Controller: "'.$controllerClass.'" Doesn\'t Exist.');
            //TODO Redirect to 404 page b2a wala 7aga.
    }
}
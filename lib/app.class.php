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
        if(method_exists($controllerObject, $controllerMethod)) {
            //RUN Controller
            $controllerObject->$controllerMethod();
            exit();
        }

        //TODO Better Redirect method by my framework
        //404 for now (kinda hardcoded :'D (for-now) )
        $errorMessage = '404 NOT-FOUND';
        $viewPath = VIEW_PATH.DS.'Err'.DS.'notfound.html';

        //Render Body
        $viewObj = new View(compact('errorMessage'), $viewPath);
        $content = $viewObj -> render();

        ///Prepare Layout
        $layout = self::$router->getRoute();
        $layoutHeaderPath = VIEW_PATH.DS.$layout.'.header.html';
        $layoutFooterPath = VIEW_PATH.DS.$layout.'.footer.html';

        //Render Header / Footer
        $headerObj = new View(array(), $layoutHeaderPath);
        $footerObj = new View(array(), $layoutFooterPath);
        $header = $headerObj->render();
        $footer = $footerObj->render();

        //Render Layout
        $layoutPath = VIEW_PATH.DS.$layout.'.html';
        $layoutView = new View(compact('content', 'header', 'footer'), $layoutPath);
        echo $layoutView -> render();
        exit();
    }
}
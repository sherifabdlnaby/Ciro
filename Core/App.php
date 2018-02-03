<?php

namespace App\Core;

class App
{
    protected static $router;
    protected static $controllerClass;
    protected static $controllerObject;
    protected static $controllerMethod;
    protected static $controllerParams;

    /**
     * @param $uri
     * @throws \Exception
     */
    public static function run(&$uri)
    {
        //Create a router  object (constructor resolves uri)
        self::$router = new Router($uri);

        //ClassName = Url Controller + 'Controller'
        $bareClassName = self::$router->getController() . 'Controller';

        //Add Namespace to have a fully qualified Controller Class name.
        self::$controllerClass = '\\App\\Controllers\\' . self::$router->getRoute() . '\\' . $bareClassName;

        //Controller's Method to be called (local variable for PHP < 7.0 compatibility with dynamic method calling using array splat).
        self::$controllerMethod = $controllerMethod = self::$router->getAction();

        //Controller's Params to be called
        self::$controllerParams = self::$router->getParams();

        //Dynamically Call Controller's Method accordingly, if any Exception is thrown a Custom Page is rendered to the user.
        try {
            //Create New Controller Object from a variable (Yeay PHP stuff :'D)
            $controllerObject = null;
            if (class_exists(self::$controllerClass))
                self::$controllerObject = $controllerObject = new self::$controllerClass();

            //Check if Controller and Action Exists in our code (with correct required params)
            if (method_exists($controllerObject, $controllerMethod) && self::checkRequiredParams())
                /* RUN Controller */
                $controllerOutput = $controllerObject->$controllerMethod(...self::$router->getParams());
            else  /* REACHING HERE means -> Routing Failed. Output full Error and send status code 404 */
                $controllerOutput = self::renderFullError("Cannot Resolve URL", 404);

        } // catch any error that occurs during execution and render a custom Error page then re-throw it again.
        catch (\Exception $exception) {
            // Render Error Page for the User ( 500 Internal Server Error ) and send status code 500.
            $controllerOutput = self::renderFullError("500 Internal Server Error", 500);
            // Throw Exception again to be handled by Exception Handler if enabled.
            // and to show Exception details for Developer in Development Environment.
            throw $exception;
        } // finally echo's the output (even if exception re-thrown to render the custom error page)
        finally {
            //echo Controller's output to user (This is our final result)
            echo $controllerOutput;
        }

        //Exit Script.
        exit();
    }

    /**
     * @return bool
     */
    private static function checkRequiredParams()
    {
        return (count(self::$controllerParams) >= (new \ReflectionMethod(self::$controllerClass, self::$controllerMethod))->getNumberOfRequiredParameters());
    }

    /**
     * a Wrapper function to render an error Page.
     * @param $message
     * @param $errorStatusCode
     * @param $layout
     * @return string
     */
    private static function renderFullError($message, $errorStatusCode = null, $layout = null)
    {
        //Use Controller renderFullError (by default WebController render HTML page, and API renders JSON error)
        if(isset(self::$controllerObject))
            return self::$controllerObject->renderFullError($message, $errorStatusCode, $layout);

        $controllerObject = new WebController();
        return $controllerObject->renderFullError($message, $errorStatusCode, $layout);
    }

    /**
     * @return Router
     */
    public static function getRouter()
    {
        return self::$router;
    }

    /**
     * @return bool
     */
    private static function checkParamsInOldPhpVersions()
    {
        if (version_compare(PHP_VERSION, '7.0.0') === -1)
            return (count(self::$controllerParams) >= (new \ReflectionMethod(self::$controllerClass, self::$controllerMethod))->getNumberOfRequiredParameters());
        else return false;
    }
}
<?php

class Router{
    protected $uri;
    protected $controller;
    protected $action;
    protected $params;
    protected $route;
    protected $routePrefix;

    /**
     * Router constructor.
     * @param $uri
     */
    public function __construct($uri)
    {
        $this->uri = urldecode(trim($uri,'/'));



        //Load Defaults
        $routes = Config::get('routes');
        $this -> route = Config::get('default_route');
        $this -> routePrefix = $routes[$this->route];
        $this -> controller = Config::get('default_controller');
        $this -> action = Config::get('default_action');

        //Parse
        $uri_parts = explode('?', $this->uri);

        //Get URL without GET? params
        $uri_path = $uri_parts[0];

        //Get Path Separated Parts
        $path_parts = explode('/', $uri_path);

        //Check if parts matches a custom Route
        Route::routeMatch($path_parts);

        if(count($path_parts))
        {
            //Get Route from first part if exits
            if( in_array(strtolower(current($path_parts)), array_keys($routes))){
                $this->route = strtolower(current($path_parts));
                $this->routePrefix = $routes[$this->route];
                array_shift($path_parts);
            }

            //Get Controller
            if(current($path_parts)){
                $this->controller = strtolower(current($path_parts));
                array_shift($path_parts);
            }

            //Get Action
            if( current($path_parts) ){
                $this->action = strtolower(current($path_parts));
                array_shift($path_parts);
            }

            //Get Params
            $this -> params = $path_parts;

        }
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * @return string
     */
    public function getRoutePrefix()
    {
        return $this->routePrefix;
    }

    /**
     * @param string $routePrefix
     */
    public function setRoutePrefix($routePrefix)
    {
        $this->routePrefix = $routePrefix;
    }

}
<?php

class Router{
    protected $uri;
    protected $controller;
    protected $action;
    protected $params;
    protected $route;

    protected $route_prefix;

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
        $this -> route_prefix = isset($routes[$this -> route]) ? $routes[$this -> route] : '';
        $this -> controller = Config::get('default_controller');
        $this -> action = Config::get('default_action');

        //Parse

        $uri_parts = explode('?', $this->uri);

        //Get URL without GET parms
        $uri_path = $uri_parts[0];

        $path_parts = explode('/', $uri_path);

        echo "<pre>"; print_r($path_parts);

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

}
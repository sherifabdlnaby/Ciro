<?php

namespace Framework6800\Lib;

abstract class  Controller{
    protected $data;
    protected $model;
    protected $params;

    /**
     * Controller constructor.
     * @param $data
     * @param $model
     * @param $params
     */
    public function __construct($data = array(), $model = array(), $params = array())
    {
        $this->data = $data;
        $this->model = $model;
        $this->params = App::getRouter() -> getParams();
    }

    /** Redirect User to the given path.
     * @param $path
     * @return null
     */
    function redirect($path)
    {
        header("Location: ".$path);
        return null;

        /*
        * Return null, only header with no test is sent, hence browsers will redirect following the location.
        (can be void, I returned null just to avoid some IDEs warnings when returning a void function,
        It doesn't impact result or performance whatsoever )
        */
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }
}
<?php

class View{
    protected $data;
    protected $path;

    /**
     * View constructor.
     * @param $data
     * @throws Exception
     */
    public function __construct($data = array(), $path = null)
    {
        if (!$path)
        {
            $path = self::getDefaultViewPath();
        }
        if(!file_exists($path))
            throw new Exception("Template not found at ".$path);

        $this->path = $path;
        $this->data = $data;
    }

    public static function getDefaultViewPath()
    {
        $router = App::getRouter();
        if(!$router)
            throw new Exception("Router not available.");

        $controllerDir = $router -> getController();
        $templateName = $router -> getRoutePrefix().$router -> getAction().'.html';

        return VIEW_PATH.DS.$controllerDir.DS.$templateName;
    }

    public function render(){
        $data = $this -> data;

        ob_start();
        include($this -> path);
        $content = ob_get_clean();

        return $content;
    }


}
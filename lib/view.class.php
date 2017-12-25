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
            $path = self::getDefaultViewPath();

        if(!file_exists($path))
            throw new Exception("Template not found at ".$path);

        $this->path = $path;
        $this->data = $data;
    }

    public static function getDefaultViewPath()
    {
        $router = App::getRouter();
        $controllerDir = $router -> getController();
        $templateName = $router -> getRoutePrefix().$router -> getAction().'.html';
        return VIEW_PATH.DS.$controllerDir.DS.$templateName;
    }

    public function render(){
        //This var to use $data['xxx'] in the view file without $this -> data.
        $data = &$this -> data;

        //START RENDERING
        ob_start();

        //Render files
        include($this -> path);

        //Collect output
        $content = ob_get_clean();

        //return
        return $content;
    }

    public static function renderAlerts($data = array())
    {

        //TODO COMPACT
        //START RENDERING
        ob_start();

        //Render Error Alerts
        if(isset($data['_errorAlerts']))
        {
            //Render Errors
            include(ALERT_VIEW_PATH.DS.'error.html');
            //Clean Errors
            unset($data['errorAlerts']);
        }

        //Render Warning Alerts
        if(isset($data['_warningAlerts']))
        {
            //Render Errors
            include(ALERT_VIEW_PATH.DS.'warning.html');
            //Clean Errors
            unset($data['_warningAlerts']);
        }

        //Render Info Alerts
        if(isset($data['_infoAlerts']))
        {
            //Render Errors
            include(ALERT_VIEW_PATH.DS.'info.html');
            //Clean Errors
            unset($data['_infoAlerts']);
        }

        //Render Success Alerts
        if(isset($data['_successAlerts']))
        {
            //Render Errors
            include(ALERT_VIEW_PATH.DS.'success.html');
            //Clean Errors
            unset($data['_successAlerts']);
        }

        //Collect output
        $content = ob_get_clean();

        //return
        return $content;
    }

}
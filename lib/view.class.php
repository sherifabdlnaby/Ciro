<?php

class View{
    protected $data;
    protected $meta;
    protected $path;

    /**
     * View constructor.
     * @param $data
     * @throws Exception
     */
    public function __construct($data = array(), $path = null, $meta = null)
    {
        if (!$path)
            $path = self::getDefaultViewPath();

        if(!file_exists($path))
            throw new Exception("Template not found at ".$path);

        $this->path = $path;
        $this->data = $data;
        $this->meta = $meta;
    }

    public static function getDefaultViewPath()
    {
        $router = App::getRouter();
        $controllerDir = $router -> getController();
        $templateName = $router -> getRoutePrefix().$router -> getAction().'.html';
        return VIEW_PATH.DS.$controllerDir.DS.$templateName;
    }

    public function render(){
        //This var to use $data['xxx'] / $meta['xxx']  in the view file without $this -> data.
        $data = &$this -> data;
        $meta = &$this -> meta;

        //START RENDERING
        ob_start();

        //Render files
        include($this -> path);

        //Collect output
        $content = ob_get_clean();

        //return
        return $content;
    }

    public static function renderAlerts(&$data, $layoutAlertDir)
    {
        //START RENDERING
        ob_start();

        //Render Error Alerts
        if(isset($data['errorAlerts']))
        {
            //Render Errors
            include($layoutAlertDir.DS.'errors.html');
            //Clean Errors
            unset($data['errorAlerts']);
        }

        //Render Warning Alerts
        if(isset($data['warningAlerts']))
        {
            //Render Errors
            include($layoutAlertDir.DS.'warnings.html');
            //Clean Errors
            unset($data['warningAlerts']);
        }

        //Render Info Alerts
        if(isset($data['infoAlerts']))
        {
            //Render Errors
            include($layoutAlertDir.DS.'infos.html');
            //Clean Errors
            unset($data['infoAlerts']);
        }

        //Render Success Alerts
        if(isset($data['successAlerts']))
        {
            //Render Errors
            include($layoutAlertDir.DS.'successes.html');
            //Clean Errors
            unset($data['successAlerts']);
        }

        //unset parent array.
        unset($data);

        //Collect output
        $content = ob_get_clean();

        //return
        return $content;
    }

}
<?php

class Controller{
    protected $data;
    protected $alerts;
    protected $meta;
    protected $model;
    protected $params;

    /**
     * Controller constructor.
     * @param array $data
     * @param array $meta
     * @param array $alerts
     */
    public function __construct($data = array(), $meta = array(), $alerts = array())
    {
        $this->data = $data;
        $this->meta = $meta;
        $this->alerts = $alerts;
        $this->params = App::getRouter() -> getParams();
    }

    /** Render controller, default view is rendered if no path specified
     * @param null $viewPath
     * @param null $layout
     */
    function render($viewPath = null, $layout = null){
        ///Prepare Layout
        if(!$layout)
            $layout = Config::get('default_layout');

        //Layout Paths
        $layoutPath       = LAYOUT_VIEW_PATH.DS.$layout.DS.'layout.html';
        $layoutHeaderPath = LAYOUT_VIEW_PATH.DS.$layout.DS.'header.html';
        $layoutFooterPath = LAYOUT_VIEW_PATH.DS.$layout.DS.'footer.html';
        $layoutMetaPath   = LAYOUT_VIEW_PATH.DS.$layout.DS.'meta.html';
        $layoutAlertsDir  = LAYOUT_VIEW_PATH.DS.$layout.DS.'alerts';

        //Render Header / Footer / Meta / Body
        $bodyObj    = new View($this->data, $viewPath);
        $headerObj  = new View(array(), $layoutHeaderPath);
        $footerObj  = new View(array(), $layoutFooterPath);
        $metaObj    = new View(array(), $layoutMetaPath, $this->meta);

        //Do The Render
        $content = $bodyObj  ->render();
        $header  = $headerObj->render();
        $footer  = $footerObj->render();
        $meta    = $metaObj  ->render();

        //Render Alerts
        $alerts = View::renderAlerts($this->alerts, $layoutAlertsDir);

        //Render Full Layout
        $layoutView = new View(compact('meta','header','alerts','content', 'footer'), $layoutPath);

        //Print Full Rendered Page
        echo $layoutView -> render();

        //Exit Script
        exit();
    }

    /** Redirect User to the given path.
     * @param $path
     */
    function redirect($path)
    {
        header("Location: ".$path);
        exit();
    }

    /** Render Custom Full Error page and send the corresponding error status code
     * @param $errorNum
     */
    function renderFullError($errorNum){
        http_response_code($errorNum);
        $errorPath = ERROR_VIEW_PATH.DS.$errorNum.'.html';
        $this -> render($errorPath);
    }

    /** Redirect User to Login if he isn't logged in */
    function verifyLoggedIn(){
        if(!Session::isLoggedIn()) {
            $this->redirect('/Account/Login' . '?returnUrl=' . $_SERVER['REQUEST_URI']);
        }
    }

    /** Redirect User to Homepage if he is logged in */
    function verifyNotLoggedIn(){
        if(Session::isLoggedIn()) {
            $this->redirect('/');
        }
    }

    /** Add Error Alerts to be rendered to user when controller's $this -> render() is called
     * @param $errorAlert
     */
    function addErrorAlert($errorAlert)
    {
        if(!isset($this->alerts['errorAlerts']))
            $this->alerts['errorAlerts'] = array();

        array_push($this->alerts['errorAlerts'], $errorAlert);
    }

    /** Add Warning Alerts to be rendered to user when controller's $this -> render() is called
     * @param $warningAlert
     */
    function addWarningAlert($warningAlert)
    {
        if(!isset($this->alerts['warningAlerts']))
            $this->alerts['warningAlerts'] = array();

        array_push($this->alerts['warningAlerts'], $warningAlert);
    }

    /** Add info Alerts to be rendered to user when controller's $this -> render() is called
     * @param $infoAlert
     */
    function addInfoAlert($infoAlert)
    {
        if(!isset($this->alerts['infoAlerts']))
            $this->alerts['infoAlerts'] = array();

        array_push($this->alerts['infoAlerts'], $infoAlert);
    }

    /** Add success Alerts to be rendered to user when controller's $this -> render() is called
     * @param $successAlert
     */
    function addSuccessAlert($successAlert)
    {
        if(!isset($this->alerts['successAlerts']))
            $this->alerts['successAlerts'] = array();

        array_push($this->alerts['successAlerts'], $successAlert);
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
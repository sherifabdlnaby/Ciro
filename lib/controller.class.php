<?php

class Controller{
    protected $data;
    protected $model;
    protected $params;

    /**
     * Controller constructor.
     * @param $data
     */
    public function __construct($data = array())
    {
        $this->data = $data;
        $this->params = App::getRouter() -> getParams();
    }

    /** Render controller, default view is rendered if no path specified
     * @param null $viewPath
     */
    function render($viewPath = null){
        //Render Body
        $viewObj = new View($this ->data, $viewPath);
        $content = $viewObj -> render();

        ///Prepare Layout
        $layout = App::getRouter() -> getRoute();
        $layoutHeaderPath = LAYOUT_VIEW_PATH.DS.$layout.'.header.html';
        $layoutFooterPath = LAYOUT_VIEW_PATH.DS.$layout.'.footer.html';

        //Render Header / Footer
        $headerObj = new View(array(), $layoutHeaderPath);
        $footerObj = new View(array(), $layoutFooterPath);
        $header = $headerObj->render();
        $footer = $footerObj->render();

        //Render Alerts;
        $alerts = View::renderAlerts($this->data);

        //Render Layout
        $layoutPath = LAYOUT_VIEW_PATH.DS.$layout.'.html';
        $layoutView = new View(compact('content', 'header', 'footer', 'alerts'), $layoutPath);

        echo $layoutView -> render();

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
        if(!isset($this->data['_errorAlerts']))
            $this -> data['_errorAlerts'] = array();
        array_push($this->data['_errorAlerts'], $errorAlert);
    }

    /** Add Warning Alerts to be rendered to user when controller's $this -> render() is called
     * @param $warningAlert
     */
    function addWarningAlert($warningAlert)
    {
        if(!isset($this->data['_warningAlerts']))
            $this -> data['_warningAlerts'] = array();
        array_push($this->data['_warningAlerts'], $warningAlert);
    }

    /** Add info Alerts to be rendered to user when controller's $this -> render() is called
     * @param $infoAlert
     */
    function addInfoAlert($infoAlert)
    {
        if(!isset($this->data['_infoAlerts']))
            $this -> data['_infoAlerts'] = array();
        array_push($this->data['_infoAlerts'], $infoAlert);
    }

    /** Add success Alerts to be rendered to user when controller's $this -> render() is called
     * @param $successAlert
     */
    function addSuccessAlert($successAlert)
    {
        if(!isset($this->data['_successAlerts']))
            $this -> data['_successAlerts'] = array();
        array_push($this->data['_successAlerts'], $successAlert);
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
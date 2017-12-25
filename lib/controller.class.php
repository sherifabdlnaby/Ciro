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

        //Render Layout
        $layoutPath = LAYOUT_VIEW_PATH.DS.$layout.'.html';
        $layoutView = new View(compact('content', 'header', 'footer'), $layoutPath);

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

    /** Add Error Messages to be rendered to user when $this -> render() is called
     * @param $errorMessage
     */
    function addError($errorMessage)
    {
        if(!isset($this->data['errorMessages']))
            $this -> data['errorMessages'] = array();
        array_push($this->data['errorMessages'], $errorMessage);
    }

    /** Redirect User to Login if he isn't logged in */
    function verifyLogin(){
        if(!isset($_SESSION['_id'])) {
            $this->redirect('/Account/Login?backUrl=' . $_SERVER['REQUEST_URI']);
        }
    }

    /** Render Custom Full Error page and send the corresponding error status code
     * @param $errorNum
     */
    public function renderFullError($errorNum){
        http_response_code($errorNum);
        $errorPath = ERROR_VIEW_PATH.DS.$errorNum.'.html';
        $this -> render($errorPath);
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
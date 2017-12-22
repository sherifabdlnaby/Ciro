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


    function render($viewPath = null){
        //Render Body
        $viewObj = new View($this ->data, $viewPath);
        $content = $viewObj -> render();

        ///Prepare Layout
        $layout = App::getRouter() -> getRoute();
        $layoutHeaderPath = VIEW_PATH.DS.$layout.'.header.html';
        $layoutFooterPath = VIEW_PATH.DS.$layout.'.footer.html';

        //Render Header / Footer
        $headerObj = new View(array(), $layoutHeaderPath);
        $footerObj = new View(array(), $layoutFooterPath);
        $header = $headerObj->render();
        $footer = $footerObj->render();

        //Render Layout
        $layoutPath = VIEW_PATH.DS.$layout.'.html';
        $layoutView = new View(compact('content', 'header', 'footer'), $layoutPath);
        echo $layoutView -> render();
        exit();
    }
    function redirect($path)
    {
        header("Location: ".$path);
        exit();
    }

}
<?php

class WebController extends Controller {
    protected $meta;

    /**
     * WebController constructor.
     * @param array $data
     * @param array $model
     * @param array $params
     * @param array $meta
     */
    public function __construct($data = array(), $model = array(), $params = array(), $meta = array())
    {
        parent::__construct($data,$model,$params);
        $this->meta = $meta;
    }

    /** Render controller, default view is rendered if no path specified.
     * @param null $layout
     * @param null $viewPath
     * @param null $data
     * @param null $meta
     * @return string
     */
    function render($layout = null, $viewPath = null, &$data = null, &$meta = null){

        ///If no specific Layout no, use default Layout.
        if(!$layout)
            $layout = Config::get('default_layout');

        //If no specific viewPath is passed, use default Path instead.
        if(!$viewPath)
            $viewPath = View::getDefaultViewPath();

        //If no specific $data is not passed, use Controller's $this -> data instead
        if(!$data)
            $data = $this -> data;

        //If a specific $meta is not passed, use Controller's $this -> meta instead
        if(!$meta)
            $meta = $this -> meta;


        //Layout Paths
        $layoutPath       = LAYOUT_VIEW_PATH.DS.$layout.DS.'layout.html';
        $layoutHeaderPath = LAYOUT_VIEW_PATH.DS.$layout.DS.'header.html';
        $layoutFooterPath = LAYOUT_VIEW_PATH.DS.$layout.DS.'footer.html';
        $layoutMetaPath   = LAYOUT_VIEW_PATH.DS.$layout.DS.'meta.html';
        $layoutAlertsDir  = LAYOUT_VIEW_PATH.DS.$layout.DS.'alerts';

        //A dummy Var to be passed to views that doesn't use controller's data (as View's $data is passed by reference for optimization)
        $dummyVar = null;

        //Create Header / Footer / Meta / Body Views Instances
        $bodyObj    = new View($data, $viewPath);
        $headerObj  = new View($dummyVar, $layoutHeaderPath);
        $footerObj  = new View($dummyVar, $layoutFooterPath);
        $metaObj    = new View($dummyVar, $layoutMetaPath, $meta);

        //Do The Render
        $content    = $bodyObj  ->render();
        $header     = $headerObj->render();
        $footer     = $footerObj->render();
        $meta       = $metaObj  ->render();

        //Render Alerts if exits
        $alerts = "";
        if(isset($_SESSION['_alerts']))
        {
            //Render Alerts from $_SESSION
            $alerts = View::renderAlerts($_SESSION['_alerts'], $layoutAlertsDir);

            //Unset Alerts Var
            unset($_SESSION['_alerts']);
        }

        //Render Full Layout
        $layoutView = new View(compact('meta','header','alerts','content', 'footer'), $layoutPath);

        //Return Full Rendered Page3
        return $layoutView -> render();
    }

    /** Render Custom Full Error page and send the corresponding status if passed, and an optional layout.
     * @param $message
     * @param null $errorStatusCode
     * @param null $layout
     * @return string
     */
    function renderFullError($message, $errorStatusCode = null, $layout = null){

        $this->data['message'] = $message;

        //Send response code via Header.
        if(is_numeric($errorStatusCode)){
            http_response_code($errorStatusCode);
            //Construct Error Path.
            $errorPath = ERROR_VIEW_PATH.DS.$errorStatusCode.'.html';
        }
        else
            //Construct Error Path.
            $errorPath = ERROR_VIEW_PATH.DS.'error.html';

        //render Full Error in $errorPath (error.html if no status code passed, and $errorStatusCode.html otherwise)
        return $this -> render($layout, $viewPath = $errorPath);
    }

    /** Redirect User to Login if he isn't logged in */
    function verifyLoggedIn(){
        if(!Session::isLoggedIn()) {
           $this->redirect('/Account/Login' . '?returnUrl=' . $_SERVER['REQUEST_URI']);
           //Exit the script (the whole request, sending the redirect header only)
           exit();
        }
    }

    /** Redirect User to Homepage if he is logged in */
    function verifyNotLoggedIn(){
        if(Session::isLoggedIn()) {
            $this->redirect('/');
            //Exit the script (the whole request, sending the redirect header only)
            exit();
        }
    }

    /**
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

}
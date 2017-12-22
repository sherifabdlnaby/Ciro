<?php

class ErrController extends Controller{
    protected $errorNum;
    //TODO Deny Routing
    public function __construct($errorNum)
    {
     $this -> errorNum = $errorNum;
    }

    public function SendAndRenderError(){
        http_response_code($this -> errorNum);
        $errorPath = VIEW_PATH.DS.'Err'.DS.$this -> errorNum.'.html';
        $this -> render($errorPath);
        exit();     //Render will exit() anyway, exit() here for visibility
    }
}
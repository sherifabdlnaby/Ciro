<?php
namespace Framework6800\Controllers\Web;
use Framework6800\Lib\WebController;

/*
 * Class Name should match this pattern {Route Prefix}{Controller Name}Controller
 * route prefix for Web Controllers = "", so just use {Controller Name}Controller.
 * (unless you changed Web route prefix in config)
 */

class HomeController extends WebController {
    public function Index(){
        return $this->render();
    }

    public function About(){
        return $this->render();
    }
}
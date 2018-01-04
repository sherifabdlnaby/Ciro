<?php

/*
 * Class Name should match this pattern {Route Prefix}{Controller Name}Controller
 * route prefix for default controllers = "", so just use {Controller Name}Controller.
 * (unless you changed default route prefix in config)
 */

class HomeController extends Controller{
    public function index(){
        return $this->render();
    }

    public function About(){
        return $this->render();
    }
}
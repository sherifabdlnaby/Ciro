<?php

/*
 * Class Name should match this pattern {Route Prefix}{Controller Name}Controller
 */

class API_HomeController extends ApiController {
    public function index(){
        echo 'API WORKING';
    }

    public function About(){
        echo 'API WORKING';
    }
}
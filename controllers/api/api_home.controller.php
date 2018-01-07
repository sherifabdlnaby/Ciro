<?php

/*
 * Class Name should match this pattern {Route Prefix}{Controller Name}Controller
 */

class API_HomeController extends ApiController {
    public function index(){
        return json_encode('API');
    }
}
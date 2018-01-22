<?php namespace Framework6800\Controllers\API;
use Framework6800\Core\ApiController;

/*
 * Class Name should match this pattern {Route Prefix}{Controller Name}Controller
 */

class API_HomeController extends ApiController {
    public function index(){
        return json_encode('API');
    }
}
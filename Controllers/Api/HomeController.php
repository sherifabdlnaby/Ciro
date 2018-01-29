<?php namespace App\Controllers\Api;
use App\Core\ApiController;

/*
 * Class Name should match this pattern {Controller Name}Controller
 */

class HomeController extends ApiController {
    public function index(){
        return json_encode('API');
    }
}
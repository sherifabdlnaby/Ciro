<?php

class HomeController extends Controller{
    public function index(){
        $this -> data['test_content'] = 1337;
    }

}
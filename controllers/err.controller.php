<?php

class ErrController extends Controller{

    public function Index(){
        $this -> data['errorMessage'] = 'An Error has occurred!';
    }

    public function NotFound(){
        http_response_code(404);
        $this -> data['errorMessage'] = '404 Not found, Please check your URL';
    }
}
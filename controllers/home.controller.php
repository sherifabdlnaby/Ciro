<?php

class HomeController extends Controller{
    public function index(){
        $this->addSuccessAlert('Success');
        $this->addSuccessAlert('Success');
        $this->addErrorAlert('Success');
        $this->addErrorAlert('Success');
        $this->addWarningAlert('Success');
        $this->addWarningAlert('Success');
        $this->addInfoAlert('Success');
        $this->addInfoAlert('Success');
        $this->render();
    }

    public function About(){
        $this->render();
    }
}
<?php

class AccountController extends Controller{
    public function login(){
        $this -> data['test_content'] = 1337;
    }

    public function register(){
       if($_SERVER['REQUEST_METHOD'] == 'POST')
       {
            $name = $_POST['name'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirmPassword'];
            $email = $_POST['email'];
            $phoneNumber = $_POST['phoneNumber'];
            //VALIDATE SERVERSIDE
           //TODO
           //////////////////////
           /// ADD TO DB
           $user = new User($username,password_hash($password, PASSWORD_DEFAULT), $email, $name, $phoneNumber);
           //Generate new ID
           $user -> _id = new MongoId();
           //////////////////////
           $db = Database::getCollection("Users") -> insert($user);

           $this->redirect('/');
       }
       //ELSE GET = RENDER FORM
        $this->render();
    }

    public function logout(){
        $this -> data['test_content'] = 1337;
    }

    public function index(){
        $this -> data['test_content'] = 1337;
    }
}
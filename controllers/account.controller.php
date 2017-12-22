<?php

class AccountController extends Controller{
    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //load data
            $username = &$_POST['username'];
            $password = &$_POST['password'];

            //QueryDB
            $collection = Database::getCollection("Users");
            $query = $collection -> find(array("username" => $username));
            $queryArray = iterator_to_array($query);

            //Compare Information
            if(count($queryArray) == 1)
            {
                $user = &current($queryArray);
                if(password_verify($password, $user['passwordHash']))
                {
                    //LOGGED IN
                    $_SESSION["_id"] = $user['_id'];
                    $_SESSION["username"] = $user['username'];
                    //Redirect Home
                    $this->redirect('/');
                }
            }
            //Render Form Again with Error Messages
            $this->addError('Invalid Username or Password');
            $this ->render();
        }
        else{
            //GET -> RENDER FORM
            $this->render();
        }
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

            //TODO VALIDATE SERVERSIDE

            /// ADD TO DB
           $user = new User($username,password_hash($password, PASSWORD_DEFAULT), $email, $name, $phoneNumber);
           $user -> _id = new MongoId();
           $collection = Database::getCollection("Users");
           $collection-> insert($user);

           //SAVE SESSION
           $_SESSION["_id"] = $user -> _id;
           $_SESSION["username"] = $user -> username;

           $this->redirect('/');
       }
       //ELSE GET = RENDER FORM
        $this->render();
    }

    public function logout(){
        session_unset();
        session_destroy();
        $this->redirect('/');
    }

    public function index(){
        $this -> data['test_content'] = 1337;
    }
}
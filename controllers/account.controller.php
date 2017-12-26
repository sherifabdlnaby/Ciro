<?php

class AccountController extends Controller{
    public function index(){
        $this->renderFullError(404);
    }

    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //load data
            $username = &$_POST['username'];
            $password = &$_POST['password'];

            //QueryDB
            $collection = DBMongo::getCollection("Users");
            $user = $collection -> findOne(array("username" => $username), array('_id','username','passwordHash'));

            //Compare Information
            if($user)
            {
                if(password_verify($password, $user['passwordHash']))
                {
                    //LOGGED IN
                    Session::saveLoginSession($user['_id'], $user['username']);

                    //Redirect to returnUrl if exits, Else Redirect to Home
                    if(!empty($_GET['returnUrl']))
                        $this->redirect($_GET['returnUrl']);

                    //Redirect Home
                    $this->redirect('/');
                }
            }
            //Render Form Again with Error Messages
            $this->addErrorAlert('Invalid Username or Password');
            $this ->render();
        }
        else{
            //GET -> RENDER FORM
            $this->render();
        }
    }

    public function register(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = &$_POST['name'];
            $username = &$_POST['username'];
            $password = &$_POST['password'];
            $confirmPassword = &$_POST['confirmPassword'];
            $email = &$_POST['email'];

            $validate = true;
            //Validate required fields
            if ($name == "" || $username == "" || $password == "" || $confirmPassword == "" || $email == "") {
                $this->addErrorAlert('Please fill all required fields.');
                $validate = false;
            }

            //Validate matching passwords
            if ($password != $confirmPassword) {
                $this->addErrorAlert('Passwords don\'t match');
                $validate = false;
            }

            //Validate Password Length
            $passwordSize = strlen($password);
            if ($passwordSize < 6 ) {
                $this->addErrorAlert('Passwords must be at least 6 characters long');
                $validate = false;
            }

            if ($passwordSize > 256 ) {
                $this->addErrorAlert('Passwords is too long');
                $validate = false;
            }

            //Validate Email Format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->addErrorAlert('Invalid Email Address');
                $validate = false;
            }

            //Validate Unique fields
            //Query DB
            $collection = DBMongo::getCollection("Users");
            $user = $collection->findOne(array('$or' => array(
                array("username" => $username),
                array("email" => $email)
            )), array('username', 'email'));

            //Check
            if ($user) {
                if ($user['username'] == $username)
                    $this->addErrorAlert('Username Already Used.');
                if ($user['email'] == $email)
                    $this->addErrorAlert('Email Already Used.');
                $validate = false;
            }

            //Save User to DB + add to Session.
            if ($validate == true) {
                /// ADD TO DB
                $user = new User($username, password_hash($password, PASSWORD_DEFAULT), $email, $name);
                $user->_id = new MongoId();
                $collection = DBMongo::getCollection("Users");
                $collection->insert($user);

                //Save Session
                Session::saveLoginSession($user ->_id, $user ->username);

                $this->redirect('/');
            }

            //Render Form back with error alerts if Validate == false.
            else
                $this->render();
        }
        //ELSE GET = RENDER FORM
        $this->render();
    }

    public function logout(){
        Session::destroyLoginSession();
        if(!empty($_GET['returnUrl']))
            $this->redirect($_GET['returnUrl']);
        $this->redirect('/');
    }

    public function view(){
        //QueryDB
        $collection = DBMongo::getCollection("Users");
        $user = $collection -> findOne(array("username" => $this ->params[0]));

        //Compare Information
        if($user)
        {
            $this -> data['_id'] = &$user['_id'];
            $this -> data['username'] = &$user['username'];
            $this -> data['name'] = &$user['name'];
            $this -> data['email'] = &$user['email'];
            $this->render();
        }
        else{
            $this->renderFullError(404);
        }
    }

}
<?php

/*
 * Class Name should match this pattern {Route Prefix}{Controller Name}Controller
 * route prefix for default controllers = "", so just use {Controller Name}Controller.
 * (unless you changed default route prefix in config)
 */

class AccountController extends WebController {
    public function index(){
        return $this->renderFullError('Not Found', 404);
    }

    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //load data
            $username = &$_POST['username'];
            $password = &$_POST['password'];

            //QueryDB
            $user = DBSql::select('SELECT _id, username, passwordHash FROM user WHERE username = '.DBSql::quote($username));

            //Compare Information
            if(count($user) == 1)
            {
                if(password_verify($password, $user[0]['passwordHash']))
                {
                    //LOGGED IN
                    Session::saveLoginSession($user[0]['_id'], $user[0]['username']);

                    //Redirect to returnUrl if exits, Else Redirect to Home
                    if(!empty($_GET['returnUrl']))
                        $this->redirect($_GET['returnUrl']);

                    //Redirect Home
                    return $this->redirect('/');
                }
            }
            //Render Form Again with Error Messages
            $this->addErrorAlert('Invalid Username or Password');
            return $this ->render();
        }
        else{
            //GET -> RENDER FORM
            return $this->render();
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
            $users = DBSql::select('SELECT username, email FROM user WHERE username = '.DBSql::quote($username).'OR email = '.DBSql::quote($email));

            //Check
            if (count($users) > 0) {
                if ($users[0]['username'] == $username)
                    $this->addErrorAlert('Username Already Used.');
                if ($users[0]['email'] == $email)
                    $this->addErrorAlert('Email Already Used.');
                $validate = false;
            }

            //Save User to DB + add to Session.
            if ($validate == true) {
                /// ADD TO DB
                $query = DBSql::query('INSERT INTO user(username, passwordHash, email, name) VALUES ('.
                                DBSql::quote($username).','.
                                DBSql::quote(password_hash($password, PASSWORD_DEFAULT)).','.
                                DBSql::quote($email).','.
                                DBSql::quote($name).');'
                                );

                //Save Session
                Session::saveLoginSession(DBSql::getConnection()->insert_id, $username);

                return $this->redirect('/');
            }

            //Render Form back with error alerts if Validate == false.
            else
                return $this->render();
        }
        //ELSE GET = RENDER FORM
        return $this->render();
    }

    public function logout(){
        Session::destroyLoginSession();
        if(!empty($_GET['returnUrl']))
            return $this->redirect($_GET['returnUrl']);
        return $this->redirect('/');
    }

    public function view($username){
        //QueryDB
        $user = DBSql::select('SELECT * FROM user WHERE username = '.DBSql::quote($username));

        //Compare Information
        if(count($user) > 0){
            $user = $user[0];
            $this -> data['_id'] = &$user['_id'];
            $this -> data['username'] = &$user['username'];
            $this -> data['name'] = &$user['name'];
            $this -> data['email'] = &$user['email'];
            return $this->render();
        }
        else{
            return $this->renderFullError('Not Found', 404);
        }
    }

    //MongoDB Version of Login/Register/View Actions
    /*
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
                    return $this->redirect('/');
                }
            }
            //Render Form Again with Error Messages
            $this->addErrorAlert('Invalid Username or Password');
            return $this ->render();
        }
        else{
            //GET -> RENDER FORM
            return $this->render();
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

                return $this->redirect('/');
            }

            //Render Form back with error alerts if Validate == false.
            else
                return $this->render();
        }
        //ELSE GET = RENDER FORM
        return $this->render();
    }

    public function view($username){
        //QueryDB
        $collection = DBMongo::getCollection("Users");
        $user = $collection -> findOne(array("username" => $username));

        //Compare Information
        if($user){
            $this -> data['_id'] = &$user['_id'];
            $this -> data['username'] = &$user['username'];
            $this -> data['name'] = &$user['name'];
            $this -> data['email'] = &$user['email'];
            return $this->render();
        }
        else{
           return $this->renderFullError(404);
        }
    }
    */
}
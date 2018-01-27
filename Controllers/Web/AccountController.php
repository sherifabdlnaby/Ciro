<?php namespace App\Controllers\Web;

use App\Core\Session;
use App\Core\WebController;
use App\Models\LoginService;
use App\Models\RegisterService;
use App\Models\UserRepository;

/*
 * Class Name should match this pattern {Route Prefix}{Controller Name}Controller
 * route prefix for Web Controllers = "", so just use {Controller Name}Controller.
 * (unless you changed Web route prefix in config)
 */

class AccountController extends WebController {

    public function index(){
        return $this->renderFullError('Not Found', 404);
    }

    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //LOGIN
            if(LoginService::login($_POST['username'], $_POST['password']))
            {
                //Redirect to returnUrl if exits, Else Redirect to Home
                if(!empty($_GET['returnUrl']))
                    $this->redirect($_GET['returnUrl']);

                //Redirect Home
                return $this->redirect('/');
            }
            else    //Login Failed, Render Form Again (Print alerts set by LoginService)
                return $this ->render();
        }
        else{
            //GET REQUEST -> RENDER FORM
            return $this->render();
        }
    }

    public function register(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (RegisterService::Register($_POST['name'], $_POST['username'], $_POST['password'], $_POST['confirmPassword'], $_POST['email']))
                return $this->redirect('/');
            //Render Form back with error alerts
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

        $userRepository = new UserRepository();

        $user = $userRepository -> findByUsername($username);

        //Compare Information
        if($user){
            $this -> data['_id'] = &$user->_id;
            $this -> data['username'] = &$user->username;
            $this -> data['name'] = &$user->name;
            $this -> data['email'] = &$user->email;
            return $this->render();
        }
        else{
            return $this->renderFullError('Not Found', 404);
        }
    }

}
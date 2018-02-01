<?php namespace App\Models;


use App\Core\Session;

class LoginService{
    /**
     * Login process
     * @param $username
     * @param $password
     * @return bool
     */
    public static function login($username, $password)
    {
        //Validate not empty
        if (empty($username) || empty($password))
            return false;

        // checks if user exists, if login is not blocked (due to failed logins) and if password fits the hash
        $userRepository = new UserRepository();

        $resultUser = $userRepository->findByUsername($username);

        if($resultUser && password_verify($password, $resultUser -> passwordHash))
        {
            Session::saveLoginSession($resultUser->_id, $resultUser->username);
            return true;
        }

        Session::addErrorAlert('Username or Password are incorrect');

        return false;
    }
}
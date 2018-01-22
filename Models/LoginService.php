<?php namespace Framework6800\Models;


use Framework6800\Core\Session;

class LoginService{
    /**
     * Login process
     * @param $username
     * @param $password
     * @return bool
     */
    //TODO Handle how to cleanly send error messages to form and VALIDATE form.
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
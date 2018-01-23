<?php namespace Framework6800\Models;


use Framework6800\Core\Session;

class RegisterService{
    /**
     * Login process
     * @param $name
     * @param $username
     * @param $password
     * @param $confirmPassword
     * @param $email
     * @return bool
     * @throws \Exception
     */
    //TODO Handle how to cleanly send error messages to form and VALIDATE form.
    public static function Register($name, $username, $password, $confirmPassword, $email)
    {
        $userRepository = new UserRepository();
        $validate = true;

        //Validate not empty
        if (empty($username) || empty($password) || empty($name) || empty($confirmPassword) ||empty($email))
        {
            Session::addErrorAlert('Please fill all fields.');
            return false;
        }

        //Validate matching passwords
        if ($password != $confirmPassword) {
            Session::addErrorAlert('Passwords don\'t match');
            $validate = false;
        }

        //Validate Password Length
        $passwordSize = strlen($password);
        if ($passwordSize < 6 ) {
            Session::addErrorAlert('Passwords must be at least 6 characters long');
            $validate = false;
        }

        if ($passwordSize > 256 ) {
            Session::addErrorAlert('Passwords is too long');
            $validate = false;
        }

        //Validate Email Format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::addErrorAlert('Invalid Email Address');
            $validate = false;
        }

        //Validate unique Email & Username
        $checkUser = $userRepository -> findOneByUsernameOrEmail($username, $email);

        //Check Unique Username / Password
        if ($checkUser) {
            if ($checkUser -> username == $username)
                Session::addErrorAlert('Username Already Used.');
            if ($checkUser -> email == $email)
                Session::addErrorAlert('Email Already Used.');
            $validate = false;
        }

        if($validate == false)
            return false;

        //Create User
        $newUser = new User(
            array('username'    => $username,
                  'passwordHash'    => password_hash($password, PASSWORD_DEFAULT),
                  'email'   => $email,
                  'name'    => $name
            ));

        //Save to DB
        $newUserID = $userRepository->create($newUser);

        if($newUserID)
        {
            Session::saveLoginSession($newUserID, $newUser->username);
            return true;
        }

        return false;
    }
}
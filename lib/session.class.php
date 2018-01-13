<?php

class Session{
    /** Saved Parameters to Session var for Login
     * @param $_id
     * @param $username
     */
    public static function saveLoginSession($_id, $username)
    {
        //SAVE SESSION
        $_SESSION["_id"] = $_id;
        $_SESSION["username"] = $username;
    }

    /** Return TRUE if user is logged On*/
    public static function isLoggedIn()
    {
        return isset($_SESSION['username']);
    }

    /** Unset and Destroy current Session, use for logout*/
    public static function destroyLoginSession()
    {
        session_unset();
        session_destroy();
    }

}
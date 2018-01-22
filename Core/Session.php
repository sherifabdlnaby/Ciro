<?php

namespace Framework6800\Core;

class Session
{
    /** Saved Parameters to Session var for Login
     * @param $_id
     * @param $username
     */
    public static function saveLoginSession($_id, $username)
    {
        //Regenerate new id (Avoid Session Fixation)
        session_regenerate_id();

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

    /** Add Error Alerts to be rendered to user when controller's $this -> render() is called
     * @param $errorAlert
     */
    public static function addErrorAlert($errorAlert)
    {
        //Check if _alert variable has been declared before or not.
        if (!isset($_SESSION['_alerts']))
            $_SESSION['_alerts'] = array();

        if (!isset($_SESSION['_alerts']['errorAlerts']))
            $_SESSION['_alerts']['errorAlerts'] = array();

        array_push($_SESSION['_alerts']['errorAlerts'], $errorAlert);
    }

    /** Add Warning Alerts to be rendered to user when controller's $this -> render() is called
     * @param $warningAlert
     */
    public static function addWarningAlert($warningAlert)
    {
        if (!isset($_SESSION['_alerts']))
            $_SESSION['_alerts'] = array();

        if (!isset($_SESSION['_alerts']['warningAlerts']))
            $_SESSION['_alerts']['warningAlerts'] = array();

        array_push($_SESSION['_alerts']['warningAlerts'], $warningAlert);
    }

    /** Add info Alerts to be rendered to user when controller's $this -> render() is called
     * @param $infoAlert
     */
    public static function addInfoAlert($infoAlert)
    {
        if (!isset($_SESSION['_alerts']))
            $_SESSION['_alerts'] = array();

        if (!isset($_SESSION['_alerts']['infoAlerts']))
            $_SESSION['_alerts']['infoAlerts'] = array();

        array_push($_SESSION['_alerts']['infoAlerts'], $infoAlert);
    }

    /** Add success Alerts to be rendered to user when controller's $this -> render() is called
     * @param $successAlert
     */
    public static function addSuccessAlert($successAlert)
    {
        if (!isset($_SESSION['_alerts']))
            $_SESSION['_alerts'] = array();

        if (!isset($_SESSION['_alerts']['successAlerts']))
            $_SESSION['_alerts']['successAlerts'] = array();

        array_push($_SESSION['_alerts']['successAlerts'], $successAlert);
    }

    public static function hasAlerts()
    {
        return isset($_SESSION['_alerts']);
    }

    public static function getAlerts(){
        return array(   'errorAlerts'   => self::getErrorAlerts(),
                        'warningAlerts' => self::getWarningAlerts(),
                        'infoAlerts'    => self::getInfoAlerts(),
                        'successAlerts' => self::getSuccessAlerts()
        );
    }

    public static function getErrorAlerts()
    {
        return isset($_SESSION['_alerts']['errorAlerts']) ?
            $_SESSION['_alerts']['errorAlerts'] : array();
    }

    public static function getWarningAlerts()
    {
        return isset($_SESSION['_alerts']['warningAlerts']) ?
            $_SESSION['_alerts']['warningAlerts'] : array();
    }

    public static function getInfoAlerts()
    {
        return isset($_SESSION['_alerts']['infoAlerts']) ?
            $_SESSION['_alerts']['infoAlerts'] : array();
    }

    public static function getSuccessAlerts()
    {
        return isset($_SESSION['_alerts']['successAlerts']) ?
            $_SESSION['_alerts']['successAlerts'] : array();

    }

    public static function unsetAllAlerts(){
        unset($_SESSION['_alerts']);
    }

    public static function unsetErrorAlerts(){
        unset($_SESSION['_alerts']['errorAlerts']);
    }

    public static function unsetWarningAlerts(){
        unset($_SESSION['_alerts']['warningAlerts']);
    }

    public static function unsetInfoAlerts(){
        unset($_SESSION['_alerts']['infoAlerts']);
    }

    public static function unsetSuccessAlerts(){
        unset($_SESSION['_alerts']['successAlerts']);
    }

}
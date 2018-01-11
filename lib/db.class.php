<?php

//Singleton Class
class DB
{
    protected static $instance;
    protected static $connection;
    protected static $settings = array();

    /**
     * Return mysqli object connected using config defaults.
     * Singleton connection
     * @return mysqli
     */
    public static function getConnection()
    {
        // Check if instance already exists
        if(!isset(self::$instance))
            self::$instance = new self(self::get('mysql_host'), self::get('mysql_user'), self::get('mysql_password'), self::get('mysql_db_name'));

        // Return Connection (mysqli Object)
        return self::$connection;
    }

    /**
     * Query the database directly without passing a connection.
     * @param $query string.
     * @return mysqli_result object for SELECT and equivalent queries, True for successful queries, False if otherwise.
     * @throws Exception if connection failed
     */
    public static function query($query) {
        // Connect to the database
        $connection = self::connection();

        // Query the database
        $result = $connection -> query($query);

        return $result;
    }

    /**
     * Fetch rows from the database directly into an array
     * (a Wrapper function when you will used the entire query result, but in-efficient if used unwisely)
     *
     * @param $query SELECT query string
     * @return array|bool array if success. false if failed.
     * @throws Exception
     */
    public static function select($query) {
        //Run Query
        $result = self::query($query);

        //Check if failed
        if($result === false)
            return false;

        //Collect Result
        $rows = array();
        while ($row = $result -> fetch_assoc())
            $rows[] = $row;

        return $rows;
    }

    /**
     * Escape and Quote values to be used in a SQL Query
     * (Wrapper function to be used directly without the need to have mysqli connection to invoke real_escape_string();
     * @param string $value to be escaped and quoted
     * @return string The escaped and quoted string
     * @throws Exception if Connection failed
     */
    public static function quote($value) {
        $connection = self::connection();
        return "'" . $connection -> real_escape_string($value) . "'";
    }

    /**
     * Close Connection if exists, Closing connection is Optional, connections are automatically(pooled) closed when php script
     * ends, however if the PHP script will process stuff for long periods, closing connection earlier after not needed
     * anymore is considered a good practice.
     */
    public static function closeConnection(){
        //Check if instance exists
        if(isset(self::$instance)){
            //Closes connection
            self::$connection -> close();
            //unset the instance, following connections will require re-connection to the DB.
            self::$instance = null;
        }
    }

    /**
     * Private DB constructor(Singleton Pattern).
     * @param $host
     * @param $user
     * @param $password
     * @param $db_name
     * @throws Exception if DB Connection failed.
     */
    private function __construct($host, $user, $password, $db_name)
    {
        self::$connection = new mysqli($host, $user, $password, $db_name);

        //If Error Occurred, Throw Exception
        if (self::$connection->connect_errno !== 0)
            throw new Exception('Error Connecting to MySQL Database, Error: ' . self::connection()->connect_error);
    }

    //CONFIG Functions
    public static function get($key){
        return isset(self::$settings[$key]) ? self::$settings[$key] : null;
    }

    public static function set($key, $value){
        self::$settings[$key] = $value;
    }

}
<?php

//Singleton Class
class DBPdo
{
    //Singleton Instance
    protected static $instance;
    //PDO Connection
    protected static $connection;
    //Settings array to hold PDO configurations via pdo.php
    protected static $settings = array();

    /**
     * Return PDO object connected using config defaults in pdo.php.
     * (Singleton connection)
     * @return PDO
     */
    public static function getConnection()
    {
        // Check if instance already exists
        if(!isset(self::$instance))
            self::$instance = new self(self::get('dsn'), self::get('username'), self::get('password'));

        // Return Connection (mysqli Object)
        return self::$connection;
    }

    /**
     * Query and executes in DB directly, without passing a connection, will use default connection set in configurations.
     * @param $query string.
     * @param null $bindValues
     * @return PDOStatement|bool false if query failed to execute
     */
    public static function query($query, $bindValues = null) {
        // Connect to the database
        $connection = self::getConnection();

        // Query the database
        $PDOStatement = $connection -> query($query);

        if(is_array($bindValues))
            return $PDOStatement -> execute($bindValues) ? $PDOStatement : false;
        else
            return $PDOStatement -> execute() ? $PDOStatement : false;

    }

    /**
     * Fetch rows from the database using a SELECT query fetched directly into an array.
     * (a Wrapper function when you will used the entire query result, but can be memory in-efficient if used unwisely)
     *
     * @param $query , for a SELECT query.
     * @return array|bool array if success. false if failed.
     */
    public static function select($query) {
        //Run Query
        $result = self::query($query);

        //Check if failed
        if($result === false)
            return false;

        return $result -> fetchAll();
    }

    /**
     * Escape and Quote values to be used in a SQL Query
     * @param string $value to be escaped and quoted
     * @return string The escaped and quoted string
     */
    public static function quote($value) {
        $connection = self::getConnection();
        return $connection -> quote($value);
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
            self::$connection = null;
            //unset the instance, following connections will require re-connection to the DB.
            self::$instance = null;
        }
    }

    /**
     * Private DB constructor(Singleton Pattern).
     * @param $dsn
     * @param $username
     * @param $password
     * @throws Exception if DB Connection failed.
     */
    private function __construct($dsn, $username, $password)
    {
        //If Error Occurred, Throws an Exception (caught at index.php).
        self::$connection = new PDO($dsn, $username, $password);
    }

    /* ensure true singleton */
    public function __clone()
    {
        return false;
    }

    public function __wakeup()
    {
        return false;
    }

    //CONFIG Functions
    public static function get($key){
        return isset(self::$settings[$key]) ? self::$settings[$key] : null;
    }

    public static function set($key, $value){
        self::$settings[$key] = $value;
    }

}
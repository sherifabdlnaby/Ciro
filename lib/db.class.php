<?php

//Singleton Class
class DB
{
    protected static $connection;

    /**
     * Singleton Connection
     * @return mysqli connection
     * @throws Exception if DB Connection failed.
     */
    public static function connection()
    {
        // Check if instance already exists
        if(!isset(self::$connection)) {
            self::$connection = new DB(Config::get('mysql_host'), Config::get('mysql_user'), Config::get('mysql_password'), Config::get('mysql_db_name'));
        }

        return self::$connection;
    }

    /**
     * Query the database directly without passing a connection.
     * @param $query string.
     * @return mysqli_result object for SELECT and equivalent queries, True for successful queries, False if otherwise.
     * @throws Exception if connection failed
     */
    public function query($query) {
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
    public function select($query) {
        //Run Query
        $result = $this -> query($query);

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
    public function quote($value) {
        $connection = self::connection();
        return "'" . $connection -> real_escape_string($value) . "'";
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

        if (isset(self::$connection->connect_error))
            throw new Exception('Error Connecting to MySQL Database, Error: ' . self::connection()->connect_error);
    }


}
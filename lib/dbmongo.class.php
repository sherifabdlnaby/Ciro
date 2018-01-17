<?php

//Singleton Class
class DBMongo{
    protected static $instance;
    protected static $connection;
    protected static $settings = array();

    /**
     * Private DB constructor(Singleton Pattern).
     * @throws MongoConnectionException if connection failed.
     */
    private function __construct()
    {
        //Throws MongoConnectionException if Failed to Connect.
        self::$connection = new MongoClient(self::get('mongo_server'), self::get('mongo_connect_options'));
    }

    /**
     * Return a MongoClient connection.
     * @return MongoClient
     */
    public static function getMongoClient()
    {
        if(!isset(self::$instance))
            self::$instance = new self();

        return self::$connection;
    }

    /**
     * Returns a MongoDB object, if no $dbName specified return default db specified in config.
     * if a $dbName of a db that doesn't exist, Mongo creates a new db of that name.
     * @param null $dbName
     * @return MongoDB
     * @throws MongoConnectionException if connection failed
     */
    public static function getMongoDB($dbName = null)
    {
        $connection = self::getMongoClient();

        if($dbName === null)
            $dbName = self::get('mongo_db_default_name');

        return $connection -> $dbName;
    }

    /**
     * @param $collectionName
     * @param null $dbName
     * @return MongoCollection
     * @throws Exception if Collection name doesn't match config, MongoConnectionException if connection failed.
     */
    public static function getCollection($collectionName, $dbName = null)
    {
        //If Null passed, getDatabase return default DB from Config
        $db = self::getMongoDB($dbName);

        //To Avoid creating unwanted collection when passing wrong $collection Name
        //Search for $Collection in set of available Collection (Initialized by config)
        $search = array_search($collectionName, self::get('collections'));

        if($search !== FALSE)
            return $db -> $collectionName;

        throw new Exception("No Collection with the Name: ". $collectionName.', Please check that Name matches config file.');
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

    /* ensure true singleton */
    public function __clone()
    {
        return false;
    }

    public function __wakeup()
    {
        return false;
    }

    //TODO Abstract this part
    //Config Functions
    public static function get($key){
        return isset(self::$settings[$key]) ? self::$settings[$key] : null;
    }

    public static function set($key, $value){
        self::$settings[$key] = $value;
    }

}
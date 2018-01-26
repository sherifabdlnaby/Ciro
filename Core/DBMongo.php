<?php

namespace App\Core;

//Singleton Class
class DBMongo{
    //Singleton Instance
    protected static $instance;
    //Mongo Client Connection
    protected static $client;
    //Settings array to hold Mongo configurations set via mongo.php
    protected static $settings = array();

    /**
     * Private DB constructor(Singleton Pattern).
     */
    private function __construct()
    {
        //Throws MongoConnectionException if Failed to Connect.
        self::$client = new \MongoDB\Client("mongodb://localhost:27017");
    }

    /**
     * Return a MongoClient connection.
     * @return \MongoDB\Client
     */
    public static function getMongoClient()
    {
        if(!isset(self::$instance))
            self::$instance = new self();

        return self::$client;
    }

    /**
     * Returns a Mongo Database Object, if no $dbName specified return Web db specified in config.
     * if a $dbName of a db that doesn't exist, Mongo creates a new db of that name.
     * @param null $dbName
     * @return \MongoDB\Database
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
     * @return \MongoDB\Collection
     */
    public static function getCollection($collectionName, $dbName = null)
    {
        //If Null passed, getDatabase returns the default DB from Config
        return self::getMongoDB($dbName) -> $collectionName;
    }

    /**
     * Return a new Mongo Object ID in string format.
     * @return string
     */
    public static function getNewObjectId(){
        return (string) (new \MongoDB\BSON\ObjectID());
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

    //Config Functions
    public static function get($key){
        return isset(self::$settings[$key]) ? self::$settings[$key] : null;
    }

    public static function set($key, $value){
        self::$settings[$key] = $value;
    }

}
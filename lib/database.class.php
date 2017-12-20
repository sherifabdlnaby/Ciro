<?php

class Database{
    protected static $connection;
    protected static $db;
    protected static $collections;

    /**
     * @param mixed $collections
     */
    public static function setCollections($collections)
    {
        self::$collections = $collections;
    }
    /**
     * @return mixed
     */
    public static function getDb()
    {
        return self::$db;
    }

    /**
     * @return mixed
     */
    public static function getCollection($collection)
    {
        $search = array_search($collection, self::$collections);
        if($search !== FALSE)
            return self::$db -> $collection;
        throw new Exception("No Collection with the Name: ". $collection);
    }

    /**
     * @param mixed $db
     */
    public static function setDb($db)
    {
        self::$db = self::$connection -> $db;
    }
    /**
     * @return mixed
     */
    public static function getConnection()
    {
        return self::$connection;
    }

    /**
     * @param mixed $connection
     */
    public static function setConnection($connection)
    {
        self::$connection = $connection;
    }

}
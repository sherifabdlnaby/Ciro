<?php

class DBMongo{
    protected static $connection;
    protected static $db;
    protected static $collections;

    public static function setConnection($connection)
    {
        self::$connection = $connection;
    }

    public static function setDb($db)
    {
        self::$db = self::$connection -> $db;
    }

    public static function setCollections($collections)
    {
        self::$collections = $collections;
    }

    public static function getCollection($collection)
    {
        $search = array_search($collection, self::$collections);
        if($search !== FALSE)
            return self::$db -> $collection;
        throw new Exception("No Collection with the Name: ". $collection);
    }

}
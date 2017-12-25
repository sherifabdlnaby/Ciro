<?php

//Mongo Database Setup

//Default Connection
DBMongo::setConnection(new MongoClient());  //Using Mongo default local connection using port

//Default Database to Connect to.
DBMongo::setDb('Database');

//Default Collections names (Exception thrown if dev used another collection other than what's specified here
DBMongo::setCollections(array(
    'Users',
    'Item'
));
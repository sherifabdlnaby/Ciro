<?php
//MongoDB Config Settings
DBMongo::set('mongo_db_default_name',   'default_database');
DBMongo::set('mongo_server'         ,   'mongodb://localhost:27017');
DBMongo::set('mongo_connect_options',    array("connect" => true));

//Default Collections names
// (Exception thrown if dev used another collection other than what's specified here)
DBMongo::set('collections', array(  'Users',
                                    'Item'
                                ));
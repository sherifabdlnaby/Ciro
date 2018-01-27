<?php
use App\Core\DBMongo;

//MongoDB Config Settings
DBMongo::set('mongo_server'         ,   'mongodb://localhost:27017');
DBMongo::set('mongo_connect_options',    array("connect" => true));
DBMongo::set('mongo_db_default_name',   'default_database');
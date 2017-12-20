<?php

//Database
Database::setConnection(new MongoClient());
Database::setDb('ValleyDatabase');
Database::setCollections(array(
    'Users',
    'Products'
));
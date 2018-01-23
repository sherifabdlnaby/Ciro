<?php

namespace App\Models;
use App\Core\DBMongo;

/*Rename Class to 'UserRepository' */
class UserRepository {

    private $mongoClient;
    private $collection;

    public function __construct($connection = null)
    {
        $this->mongoClient  = DBMongo::getMongoClient();
        $this->collection   = DBMongo::getCollection('user');
    }

    /**
     * @param $_id
     * @return object
     * @throws \Exception
     */
    public function find($_id)
    {
        $user = $this->collection->findOne(['_id' => $_id], ['typeMap' => ['root' => 'object']]);
        return $user;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function findAll()
    {
        $users = $this->collection->find([], ['typeMap' => ['root' => 'object']]);
        return $users->toArray();
    }

    /**
     * @param $username
     * @return \stdClass|null
     * @throws \Exception
     */
    public function findByUsername($username)
    {
        $user = $this->collection->findOne(['username' => $username], ['typeMap' => ['root' => 'object']]);
        return $user;
    }

    /**
     * @param $username
     * @param $email
     * @return User|\stdClass|null
     * @throws \Exception
     */
    public function findOneByUsernameOrEmail($username, $email)
    {
        $user = $this->collection->findOne(['$or' => [['username' => $username],['email' => $email]]], ['typeMap' => ['root' => 'object']]);
        return $user;
    }

    /**
     * @param User $user
     * @return bool|mixed
     * @throws \Exception
     */
    public function create($user)
    {
        if (isset($user -> _id))
            return $this->update($user);

        /* Create new User Document */
        //Generate New Object ID.
        $user->_id = DBMongo::getNewObjectId();
        //Insert
        $insertResult = $this->collection -> insertOne($user);
        return $insertResult->isAcknowledged() ? $insertResult->getInsertedId() : false;
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function update($user)
    {
        if (!isset($user->_id)) {
            // We can't update a record unless it exists...
            throw new \Exception(
                'Cannot update user!, user Id is null or not a valid ID.'
            );
        }

        return $this->collection->updateOne(
            ['_id' => $user->_id],
            [ '$set' => ['username' => $user->username,
                        'email' => $user->email,
                        'name' => $user->name,
                        'passwordHash' => $user->passwordHash
                        ]
            ]) ->isAcknowledged();
    }
}
<?php namespace App\Models;

use App\Core\DBSql;

/*Rename Class to 'UserRepository' */
class _disabled1UserRepository {
    private $connection;

    public function __construct($connection = null)
    {
        $this->connection = DBSql::getConnection();
    }

    /**
     * @param $id
     * @return object|\stdClass
     */
    public function find($id)
    {
        $query = $this-> connection->prepare (
        '
            SELECT * 
            FROM user 
            WHERE _id = ?
        ');

        $query -> bind_param('s', $id);

        $query -> execute();

        return $query -> get_result() -> fetch_object(User::class);
    }

    /**
     * @param $username
     * @return User|\stdClass|null
     */
    public function findByUsername($username)
    {
        $query = $this-> connection -> prepare (
            "
            SELECT * 
            FROM user 
            WHERE username = ?;
        ");

        $query -> bind_param('s', $username);

        $query -> execute();

        return $query -> get_result() -> fetch_object(User::class);
    }

    /**
     * @param $username
     * @param $email
     * @return User|\stdClass|null
     */
    public function findOneByUsernameOrEmail($username, $email)
    {
        $query = $this-> connection -> prepare (
            "
            SELECT * 
            FROM user 
            WHERE username = ? OR email = ?;
        ");

        $query -> bind_param('ss', $username, $email);

        $query -> execute();

        return $query -> get_result() -> fetch_object(User::class);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $query = $this->connection->prepare('SELECT * FROM user');

        $query->execute();

        $result = $query -> get_result();

        $list = array();
        while($tmpObj = $result -> fetch_object(User::class))
            array_push($list, $tmpObj);

        return $list;
    }

    /**
     * @param User $user
     * @return int:bool
     * @throws \Exception
     */
    public function create($user)
    {
        if (isset($user -> _id))
            return $this->update($user);

        $query = $this->connection->prepare('
            INSERT INTO user 
                (username, passwordHash, email, name) 
            VALUES 
                (?, ? , ?, ?)
        ');

        $query->bind_param('ssss', $user->username, $user->passwordHash,  $user->email, $user->name);

        return $query->execute() ? $query -> insert_id : false;
    }

    /**
     * @param User $user
     * @return bool
     * @throws /Exception
     */
    public function update($user)
    {
        if (!isset($user->_id)) {
            // We can't update a record unless it exists...
            throw new \Exception(
                'Cannot update user that does not yet exist in the database.'
            );
        }

        $query = $this->connection->prepare('
            UPDATE user
            SET username = ?,
                passwordHash = ?,
                email = ?,
                name = ?
            WHERE _id = ?
        ');

        $query->bind_param('sssss', $user->username, $user->passwordHash, $user->email, $user->name, $user->_id);

        return $query->execute();
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteById($id)
    {
        $query = $this->connection->prepare('
            DELETE FROM user
            WHERE _id = ?
        ');
        $query -> bind_param('s', $id);
        return $query->execute();
    }
}
<?php
class UserRepository {
    private $connection;

    public function __construct($connection = null)
    {
        $this->connection = DBPdo::getConnection();
    }

    /**
     * @param $id
     * @return bool
     */
    public function find($id)
    {
        $query = $this-> connection->prepare (
        '
            SELECT * 
            FROM user 
            WHERE id = :id
        ');

        $query -> bindparam(':id', $id);

        $query -> execute();

        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');

        return $query -> fetch();
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $query = $this->connection->prepare('
            SELECT * FROM user
        ');
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');

        return $query -> fetchAll();
    }

    /**
     * @param $username
     * @return User|stdClass|null
     */
    public function findByUsername($username)
    {
        $query = $this-> connection -> prepare (
            "
            SELECT * 
            FROM user 
            WHERE username = :username;
        ");

        $query -> bindparam(':username', $username);

        $query -> execute();

        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');

        return $query -> fetch();
    }

    /**
     * @param $username
     * @param $email
     * @return User|stdClass|null
     */
    public function findOneByUsernameOrEmail($username, $email)
    {
        $query = $this-> connection -> prepare (
            "
            SELECT * 
            FROM user 
            WHERE username = :username OR email = :email;
        ");

        $query -> bindparam(':username', $username);
        $query -> bindparam(':email', $email);

        $query -> execute();

        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');

        return $query -> fetch();
    }

    /**
     * @param User $user
     * @return int last insert id:bool if failed;
     * @throws Exception
     */
    public function create($user)
    {
        if (isset($user -> _id))
            return $this->update($user);

        $query = $this->connection->prepare('
            INSERT INTO user 
                (username, passwordHash, email, name) 
            VALUES 
                (:username, :passwordHash , :email, :name)
        ');

        $query->bindParam(':username', $user->username);
        $query->bindParam(':passwordHash', $user->passwordHash);
        $query->bindParam(':email', $user->email);
        $query->bindParam(':name', $user->name);

        return $query->execute() ? $this->connection->lastInsertId('user__id_seq') : false;
    }

    /**
     * @param User $user
     * @return bool
     * @throws Exception
     */
    public function update($user)
    {
        if (!isset($user->_id)) {
            // We can't update a record unless it exists...
            throw new Exception(
                'Cannot update user!, user Id is null.'
            );
        }

        $query = $this->connection->prepare('
            UPDATE user
            SET username = :username,
                passwordHash = :passwordHash,
                email = :email,
                name = :name
            WHERE _id = :_id
        ');

        $query->bindParam(':username', $user->username);
        $query->bindParam(':passwordHash', $user->passwordHash);
        $query->bindParam(':name', $user->name);
        $query->bindParam(':email', $user->email);
        $query->bindParam(':_id', $user->_id);

        return $query->execute();
    }
}
<?php namespace Framework6800\Models;

class User {
    public $_id;
    public $username;
    public $passwordHash;
    public $email;
    public $name;

    /**
     * User constructor.
     * @param $username
     * @param $passwordHash
     * @param $email
     * @param $name
     * @param $phoneNumber
     * @param null $_id
     */
    public function __construct($data = null)
    {
        if (is_array($data))
        {
            if (isset($data['_id']))
                $this->_id = $data['_id'];
            $this->username = $data['username'];
            $this->passwordHash = $data['passwordHash'];
            $this->email = $data['email'];
            $this->name = $data['name'];

        }
    }
}
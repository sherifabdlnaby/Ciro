<?php namespace App\Models;

class User {
    public $_id;
    public $username;
    public $passwordHash;
    public $email;
    public $name;

    /**
     * User constructor.
     * @param null $data
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
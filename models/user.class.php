<?php
class User{
    public $_id;
    public $username;
    public $passwordHash;
    public $email;
    public $name;
    public $phoneNumber;

    /**
     * User constructor.
     * @param $username
     * @param $passwordHash
     * @param $email
     * @param $name
     * @param $phoneNumber
     * @param null $_id
     */
    public function __construct($username = null, $passwordHash= null, $email= null, $name= null, $phoneNumber= null)
    {
        $this->username = $username;
        $this->passwordHash = $passwordHash;
        $this->email = $email;
        $this->name = $name;
        $this->phoneNumber = $phoneNumber;
    }
}
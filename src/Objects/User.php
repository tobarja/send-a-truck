<?php

namespace SendATruck\Objects;

class User extends DataMapperObject
{

    const MINIMUM_PASSWORD_LENGTH = 8;

    protected $id;
    protected $userName;
    protected $password;

    public function __construct(array $data = array())
    {
        $fieldMaps = array(
            'id' => 'id',
            'userName' => 'username',
            'password' => 'password'
        );
        parent::__construct($fieldMaps, $data);
    }

    public function getId()
    {
        return $this->id;
    }

    protected function setId($id)
    {
        $this->id = $id;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function getHashedPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        if (is_null($password)) {
            throw new \InvalidArgumentException('Password can not be null');
        }
        if (strlen($password) < self::MINIMUM_PASSWORD_LENGTH) {
            throw new \InvalidArgumentException('Password must be at least '.self::MINIMUM_PASSWORD_LENGTH.' characters');
        }
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function isPassword($password)
    {
        return password_verify($password, $this->password);
    }
}

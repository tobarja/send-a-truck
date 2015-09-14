<?php

namespace SendATruck\Objects;

class User
{

    private $id;
    private $userName;
    private $password;

    public function __construct($userName = "", $password = null)
    {
        $this->userName = $userName;
        if (!is_null($password)) {
            $this->password = password_hash($password, PASSWORD_DEFAULT);
        }
    }

    /**
     * @param int $id
     * @param string $userName
     * @param string $password
     * @return SendATruck\Objects\User
     */
    public static function Hydrate($id, $userName, $password)
    {
        $result = new User($userName);
        $result->setId($id);
        $result->setHashedPassword($password);

        return $result;
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

    public function getHashedPassword()
    {
        return $this->password;
    }

    public function setHashedPassword($password)
    {
        $this->password = $password;
    }

    public function isPassword($password)
    {
        return password_verify($password, $this->password);
    }
}

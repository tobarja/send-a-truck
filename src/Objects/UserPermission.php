<?php

namespace SendATruck\Objects;

class UserPermission
{
    private $id;
    private $userId;
    private $permission;

    public function __construct($userId, $permission)
    {
        $this->userId = $userId;
        $this->permission = $permission;
    }

    public static function Hydrate($id, $userId, $permission)
    {
        $result = new UserPermission($userId, $permission);
        $result->setId($id);
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

    public function getUserId()
    {
        return $this->userId;
    }

    public function getPermission()
    {
        return $this->permission;
    }
}

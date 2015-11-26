<?php

namespace SendATruck\Objects;

class UserPermission extends DataMapperObject
{
    protected $id;
    protected $userId;
    protected $permission;

    public function __construct(array $data = array())
    {
        $fieldMaps = array(
            'id' => 'id',
            'userId' => 'user_id',
            'permission' => 'permission'
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

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getPermission()
    {
        return $this->permission;
    }

    public function setPermission($permissionName)
    {
        $this->permission = $permissionName;
    }
}

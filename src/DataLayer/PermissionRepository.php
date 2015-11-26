<?php

namespace SendATruck\DataLayer;

use SendATruck\Objects\UserPermission;

class PermissionRepository
{

    /**
     * @var \PDO
     */
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function add(UserPermission $permission)
    {
        $query = "INSERT INTO UserPermissions (user_id, permission)"
            . " VALUES (:user_id, :permission)";
        $statement = $this->db->prepare($query);
        $fields = $permission->toDatabaseArray();
        unset($fields['id']);

        return $statement->execute($fields);
    }

    public function getById($id)
    {
        $query = <<<EOT
            SELECT id, user_id, permission
            FROM UserPermissions
            WHERE id = :id
EOT;
        $statement = $this->db->prepare($query);
        $statement->bindParam("id", $id, \PDO::PARAM_INT);
        $dbResult = $statement->execute();
        $func = function ($row) {
            return new UserPermission($row);
        };
        if ($dbResult) {
            $rows = $statement->fetchAll();
            if (count($rows)) {
                return $func($rows[0]);
            }
        }
        return new UserPermission();
    }

    public function getByUserId($userId)
    {
        $query = <<<EOT
            SELECT id, user_id, permission
            FROM UserPermissions
            WHERE user_id = :user_id
EOT;
        $statement = $this->db->prepare($query);
        $statement->bindParam("user_id", $userId, \PDO::PARAM_INT);
        $dbResult = $statement->execute();
        $result = array();
        if ($dbResult) {
            $rows = $statement->fetchAll();
            foreach ($rows as $row) {
                $result[] = new UserPermission($row);
            }
        }
        return $result;
    }

    public function hasPermission($permission, $userId)
    {
        $query = <<<EOT
            SELECT id, user_id, permission
            FROM UserPermissions
            WHERE user_id = :user_id and permission = :permission
EOT;
        $statement = $this->db->prepare($query);
        $statement->bindParam("user_id", $userId, \PDO::PARAM_INT);
        $statement->bindParam("permission", $permission, \PDO::PARAM_STR);
        $dbResult = $statement->execute();
        if ($dbResult) {
            $rows = $statement->fetchAll();
            if (count($rows) == 1) {
                return true;
            }
        }
        return false;
    }

    public function remove($permissionId)
    {
        $query = "DELETE FROM UserPermissions"
            . " WHERE id = :id";
        $statement = $this->db->prepare($query);
        $statement->bindParam("id", $permissionId, \PDO::PARAM_INT);
        return $statement->execute();
    }
}

<?php

namespace SendATruck\DataLayer;

use SendATruck\Objects\User;

class UserRepository
{

    /**
     * @var \PDO
     */
    private $db;
    private $baseQuery;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
        $this->baseQuery = <<<EOT
            SELECT id, username, password
            FROM Users
EOT;
    }

    public function add(User $user)
    {
        try {
            $query = <<<EOT
            INSERT INTO Users (username, password)
            VALUES (:username, :password)
EOT;
            $this->db->beginTransaction();
            $statement = $this->db->prepare($query);
            $username = $user->getUserName();
            $password = $user->getHashedPassword();
            $statement->bindParam("username", $username, \PDO::PARAM_STR);
            $statement->bindParam("password", $password, \PDO::PARAM_STR);
            if ($statement->execute()) {
                $id = $this->db->lastInsertId();
                $this->db->commit();
                return $id;
            }

            $this->db->rollBack();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return false;
    }

    public function getAll()
    {
        $statement = $this->db->prepare($this->baseQuery);
        $dbResult = $statement->execute();
        $result = array();
        if ($dbResult) {
            $rows = $statement->fetchAll();
            foreach ($rows as $row) {
                $result[] = User::Hydrate($row['id'], $row['username'],
                        $row['password']);
            }
        } else {
            // TODO: Logging:print_r($statement->errorInfo());
        }
        return $result;
    }

    public function getById($userId)
    {
        $query = $this->baseQuery
            . " WHERE id = :id";
        $statement = $this->db->prepare($query);
        $statement->bindParam("id", $userId, \PDO::PARAM_INT);
        $dbResult = $statement->execute();
        $func = function ($row) {
            return User::Hydrate($row['id'], $row['username'], $row['password']);
        };
        if ($dbResult) {
            $rows = $statement->fetchAll();
            if (count($rows)) {
                return $func($rows[0]);
            }
        }
    }

    /**
     * @param string $userName
     * @return \SendATruck\Objects\User
     */
    public function getByUserName($userName)
    {
        $query = $this->baseQuery
            . " WHERE username = :username";
        $statement = $this->db->prepare($query);
        $statement->bindParam("username", $userName, \PDO::PARAM_STR);
        $dbResult = $statement->execute();
        $func = function ($row) {
            return User::Hydrate($row['id'], $row['username'], $row['password']);
        };
        if ($dbResult) {
            $rows = $statement->fetchAll();
            if (count($rows)) {
                return $func($rows[0]);
            }
        }
        return new User();
    }
}

<?php

namespace SendATruck\DataLayer;

use SendATruck\Objects\TruckRequest;

class TruckRequestRepository
{

    /**
     * @var \PDO
     */
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $sql = <<<EOT
            SELECT id, customer_id, timestamp 
            FROM TruckRequests
EOT;

        $statement = $this->db->prepare($sql);
        $dbResult = $statement->execute();
        $result = array();
        if ($dbResult) {
            $rows = $statement->fetchAll();
            foreach ($rows as $row) {
                $result[] = TruckRequest::Hydrate($row['id'],
                        $row['customer_id'], new \DateTime($row['timestamp']));
            }
        }
        return $result;
    }

    public function save(TruckRequest $truckRequest)
    {
        if ($truckRequest->getId()) {
            $this->update($truckRequest);
        } else {
            $this->create($truckRequest);
        }
    }

    private function create(TruckRequest $truckRequest)
    {
        $sql = <<<EOT
            INSERT INTO TruckRequests (customer_id, timestamp)
            VALUES (:customer_id, :timestamp)
EOT;

        $statement = $this->db->prepare($sql);
        $statement->bindParam('customer_id', $truckRequest->getCustomerId(),
            \PDO::PARAM_INT);
        $statement->bindParam('timestamp',
            $truckRequest->getTimestamp()->format("Y-m-d H:i:s"),
            \PDO::PARAM_STR);
        if ($statement->execute()) {
            return $this->getLastInsertId();
        }
        return false;
    }

    private function update(TruckRequest $truckRequest)
    {
        $sql = <<<EOT
            UPDATE truckrequests (customer_id, timestamp)
            SET customer_id = :customer_id,
                timestamp = :timestamp
            WHERE id = :id;
EOT;

        $statement = $this->db->prepare($sql);
        $statement->bindParam('customer_id', $truckRequest->getCustomerId(),
            \PDO::PARAM_INT);
        $statement->bindParam('timestamp',
            $truckRequest->getTimestamp()->format("Y-m-d H:i:s"),
            \PDO::PARAM_STR);
        $statement->bindParam('id', $truckRequest->getId(), \PDO::PARAM_INT);
        return $statement->execute();
    }

    private function getLastInsertId()
    {
        $sql = "SELECT LAST_INSERT_ID();";
        $statement = $this->db->prepare($sql);
        if ($statement->execute()) {
            return $statement->fetchColumn(0);
        } else {
            return false;
        }
    }
}

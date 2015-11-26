<?php

namespace SendATruck\DataLayer;

use SendATruck\Objects\CustomerTruckRequest;

class CustomerTruckRequestRepository
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
            SELECT tr.id as tr_id, tr.customer_id, tr.timestamp,
                c.company_name, c.address1, c.address2, c.city, c.state, c.zip
            FROM TruckRequests tr
            INNER JOIN Customers c on tr.customer_id = c.id
            ORDER BY tr.timestamp DESC
EOT;

        $statement = $this->db->prepare($sql);
        $dbResult = $statement->execute();
        $result = array();
        if ($dbResult) {
            $rows = $statement->fetchAll();
            foreach ($rows as $row) {
                $result[] = new CustomerTruckRequest($row);
            }
        } else {
            // TODO: Logging:print_r($statement->errorInfo());
        }
        return $result;
    }
}

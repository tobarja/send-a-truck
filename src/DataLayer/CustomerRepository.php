<?php

namespace SendATruck\DataLayer;

use SendATruck\Objects\Customer;

class CustomerRepository
{

    /**
     * @var \PDO
     */
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * 
     * @param integer $id
     * @return Customer
     */
    public function getById($id)
    {
        $sql = <<<EOT
            SELECT id, company_name, first_name, last_name, email, telephone,
                address1, address2, city, state, zip
            FROM Customers
            WHERE id = :id
EOT;
        $statement = $this->db->prepare($sql);
        $dbResult = $statement->execute(array('id' => $id));
        if ($dbResult) {
            $rows = $statement->fetchAll();
            if (count($rows) == 1) {
                $row = $rows[0];
                return Customer::Hydrate($row['id'], $row['company_name'],
                        $row['first_name'], $row['last_name'], $row['email'],
                        $row['telephone'], $row['address1'], $row['address2'],
                        $row['city'], $row['state'], $row['zip']);
            }
        }
        return new Customer();
    }

    /**
     * @return Customer[]
     */
    public function getAll()
    {
        $sql = <<<EOT
            SELECT id, company_name, first_name, last_name, email, telephone,
                address1, address2, city, state, zip
            FROM Customers
EOT;

        $statement = $this->db->prepare($sql);
        $dbResult = $statement->execute();
        $result = array();
        if ($dbResult) {
            $rows = $statement->fetchAll();
            foreach ($rows as $row) {
                $result[] = Customer::Hydrate($row['id'], $row['company_name'],
                        $row['first_name'], $row['last_name'], $row['email'],
                        $row['telephone'], $row['address1'], $row['address2'],
                        $row['city'], $row['state'], $row['zip']);
            }
        }
        return $result;
    }
}

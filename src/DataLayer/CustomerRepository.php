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

    public function add(Customer $customer)
    {
        $query = "INSERT INTO Customers (company_name, first_name, last_name,
            email, telephone, address1, address2, city, state, zip)
            VALUES (:company_name, :first_name, :last_name, :email, :telephone, 
            :address1, :address2, :city, :state, :zip)";
        $statement = $this->db->prepare($query);
        $fields = $customer->toDatabaseArray();
        unset($fields['id']);

        try {
            $this->db->beginTransaction();
            if ($statement->execute($fields)) {
                $id = $this->db->lastInsertId();
                $this->db->commit();
                return $id;
            }

            $this->db->rollBack();
        } catch (Exception $ex) {
            echo $ex->getTraceAsString();
        }
        return false;
    }

    public function update(Customer $customer)
    {
        $query = "UPDATE Customers SET company_name = :company_name, 
            first_name = :first_name, last_name = :last_name, email = :email,
            telephone = :telephone, address1 = :address1, address2 = :address2,
            city = :city, state = :state, zip = :zip
            WHERE id = :id";
        $statement = $this->db->prepare($query);
        $fields = $customer->toDatabaseArray();

        try {
            $this->db->beginTransaction();
            if ($statement->execute($fields)) {
                $this->db->commit();
            }
        } catch (Exception $ex) {
            $this->db->rollBack();
            throw $ex;
        }
    }

    /**
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
                return new Customer($rows[0]);
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
                $result[] = new Customer($row);
            }
        }
        return $result;
    }
}

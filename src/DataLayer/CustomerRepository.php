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
            email, telephone, address1, address2, city, state, zip, request_key)
            VALUES (:company_name, :first_name, :last_name, :email, :telephone, 
            :address1, :address2, :city, :state, :zip, :request_key)";
        $statement = $this->db->prepare($query);
        $fields = $customer->toDatabaseArray();
        unset($fields['id']);
        $fields['request_key'] = sha1(openssl_random_pseudo_bytes(200));

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
            city = :city, state = :state, zip = :zip, request_key = :request_key
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
     * @param string $requestKey
     * @return Customer
     */
    public function getByRequestKey($requestKey)
    {
        $sql = <<<EOT
            SELECT id, company_name, first_name, last_name, email, telephone,
                address1, address2, city, state, zip, request_key
            FROM Customers
            WHERE request_key = :request_key
EOT;
        $statement = $this->db->prepare($sql);
        $dbResult = $statement->execute(array('request_key' => $requestKey));
        if ($dbResult) {
            $rows = $statement->fetchAll();
            if (count($rows) == 1) {
                return new Customer($rows[0]);
            }
        }
        return new Customer();
    }

    /**
     * @param integer $id
     * @return Customer
     */
    public function getById($id)
    {
        $sql = <<<EOT
            SELECT id, company_name, first_name, last_name, email, telephone,
                address1, address2, city, state, zip, request_key
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
                address1, address2, city, state, zip, request_key
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

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
        $fields = $this->CustomerToArray($customer);

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

    private function CustomerToArray(Customer $customer)
    {
        $result = array();
        $result['company_name'] = $customer->getCompanyName();
        $result['first_name'] = $customer->getFirstName();
        $result['last_name'] = $customer->getLastName();
        $result['email'] = $customer->getEmail();
        $result['telephone'] = $customer->getTelephone();
        $result['address1'] = '';
        $result['address2'] = '';
        $result['city'] = '';
        $result['state'] = '';
        $result['zip'] = '';
        return $result;
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

<?php

namespace SendATruck\Objects;

class Customer
{

    private $id;
    private $companyName;
    private $firstName;
    private $lastName;
    private $email;
    private $telephone;
    private $address1;
    private $address2;
    private $city;
    private $state;
    private $zip;

    public function __construct($companyName = "", $firstName = "",
        $lastName = "", $email = "", $telephone = "", $address1 = "",
        $address2 = "", $city = "", $state = "", $zip = "")
    {
        $this->companyName = $companyName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
    }

    public static function Hydrate($id, $companyName, $firstName, $lastName,
        $email, $telephone, $address1, $address2, $city, $state, $zip)
    {
        $result = new self($companyName, $firstName, $lastName, $email,
            $telephone, $address1, $address2, $city, $state, $zip);
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

    public function getCompanyName()
    {
        return $this->companyName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }
}

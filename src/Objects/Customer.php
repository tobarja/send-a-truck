<?php

namespace SendATruck\Objects;

class Customer extends DataMapperObject
{

    protected $id;
    protected $companyName;
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $telephone;
    protected $address1;
    protected $address2;
    protected $city;
    protected $state;
    protected $zip;
    protected $requestKey;

    public function __construct(array $data = array())
    {
        $fieldMap = array (
            'id' => 'id',
            'companyName' => 'company_name',
            'firstName' => 'first_name',
            'lastName' => 'last_name',
            'email' => 'email',
            'telephone' => 'telephone',
            'address1' => 'address1',
            'address2' => 'address2',
            'city' => 'city',
            'state' => 'state',
            'zip' => 'zip',
            'requestKey' => 'request_key'
        );

        parent::__construct($fieldMap, $data);
    }

    public function getId()
    {
        return $this->id;
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

    public function getAddress1()
    {
        return $this->address1;
    }

    public function getAddress2()
    {
        return $this->address2;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getZip()
    {
        return $this->zip;
    }

    public function getRequestKey()
    {
        return $this->requestKey;
    }
}

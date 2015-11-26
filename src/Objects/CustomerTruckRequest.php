<?php

namespace SendATruck\Objects;

class CustomerTruckRequest extends DataMapperObject
{

    protected $truckRequestId;
    protected $customerId;
    protected $timestamp;
    protected $customerName;
    protected $customerAddress1;
    protected $customerAddress2;
    protected $customerCity;
    protected $customerState;
    protected $customerZip;

    public function __construct(array $data = array())
    {
        $fieldMap = array(
            'truckRequestId' => 'tr_id',
            'customerId' => 'customer_id',
            'timestamp' => 'timestamp',
            'customerName' => 'company_name',
            'customerAddress1' => 'address1',
            'customerAddress2' => 'address2',
            'customerCity ' => 'city',
            'customerState ' => 'state',
            'customerZip' => 'zip'
        );
        parent::__construct($fieldMap, $data);
    }

    public function getTruckRequestId()
    {
        return $this->truckRequestId;
    }

    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * 
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return new \DateTime($this->timestamp);
    }

    public function getCustomerName()
    {
        return $this->customerName;
    }

    public function getCustomerAddressAsString()
    {
        $result = ""
            .$this->customerAddress1." "
            .$this->customerAddress2." "
            .$this->customerCity." "
            .$this->customerState." "
            .$this->customerZip;
        return $result;
    }
}

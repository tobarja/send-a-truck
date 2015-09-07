<?php

namespace SendATruck\Objects;

class CustomerTruckRequest
{

    private $truckRequestId;
    private $customerId;

    /**
     *
     * @var \DateTime
     */
    private $timestamp;
    private $customerName;
    private $customerAddress1;
    private $customerAddress2;
    private $customerCity;
    private $customerState;
    private $customerZip;

    public function __construct($truckRequestId, $customerId,
        \DateTime $timestamp, $customerName, $customerAddress1,
        $customerAddress2, $customerCity, $customerState, $customerZip)
    {
        $this->truckRequestId = $truckRequestId;
        $this->customerId = $customerId;
        $this->timestamp = $timestamp;
        $this->customerName = $customerName;
        $this->customerAddress1 = $customerAddress1;
        $this->customerAddress2 = $customerAddress2;
        $this->customerCity = $customerCity;
        $this->customerState = $customerState;
        $this->customerZip = $customerZip;
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
        return $this->timestamp;
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

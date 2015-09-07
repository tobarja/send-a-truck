<?php

namespace SendATruck\Objects;

class TruckRequest
{
    private $id;
    private $customerId;
    /**
     *
     * @var \DateTime
     */
    private $timestamp;

    public function __construct($customerId = "", \DateTime $timestamp = null)
    {
        $this->customerId = $customerId;
        if(is_null($timestamp)) {
            $this->timestamp = $timestamp;
        } else {
            $this->timestamp = new \DateTime();
        }
    }

    public static function Hydrate($id, $customerId, $timestamp)
    {
        $object = new self($customerId, $timestamp);
        $object->id = $id;
        return $object;
    }

    public function getId()
    {
        return $this->id;
    }

    protected function setId($id)
    {
        $this->id = $id;
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
}
<?php

namespace SendATruck\Objects;

class TruckRequest extends DataMapperObject
{

    protected $id;
    protected $customerId;
    protected $timestamp;

    public function __construct(array $data = array())
    {
        $fieldMap = array(
            'id' => 'id',
            'customerId' => 'customer_id',
            'timestamp' => 'timestamp'
        );
        parent::__construct($fieldMap, $data);
        $this->timestamp = new \DateTime($this->timestamp);
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

    public function setCustomerId($custId)
    {
        $this->customerId = $custId;
    }

    public function setTimestamp()
    {
        $this->timestamp = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}

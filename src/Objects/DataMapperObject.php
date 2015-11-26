<?php

namespace SendATruck\Objects;

class DataMapperObject
{

    protected $_fieldMap;

    public function __construct(array $fieldMap = array(), array $data = array())
    {
        $this->_fieldMap = $fieldMap;
        foreach ($this->_fieldMap as $key => $value) {
            if (isset($data[$value])) {
                $this->$key = $data[$value];
            }
        }
    }

    public function toDatabaseArray()
    {
        $result = array();
        foreach ($this->_fieldMap as $key => $value) {
            $result[$value] = $this->$key;
        }
        return $result;
    }
}

<?php
namespace AHT\Core;

use ReflectionClass;

class Model
{
    // public function getProperties(){
    //     return get_object_vars($this);
    // }
    public function getProperties() 
    {
        $reflect = new ReflectionClass($this);
        $props   = $reflect->getProperties();
        $properties = array();
        foreach ($props as $prop) {
            array_push($properties, $prop->getName());
        }
        return $properties;
    }
}
?>
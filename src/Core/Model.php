<?php
namespace AHT\Core;

use ReflectionClass;

class Model
{
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

    public function updateString()
    {   
        $properties = $this->getProperties();
        $str = "";
        for($i = 0; $i <count($properties)-3; $i++)
        {
            $str = $str . $properties[$i] . "=:" . $properties[$i] . ",";
        }
        $str = $str . $properties[count($properties)-2] . "=:" . $properties[count($properties)-2];
        return $str;
    }

    public function updateValues($id_name, $id)
    {
        $properties = $this->getProperties();
        $values = [];
        for ($i = 0; $i <count($properties)-3; $i++) {
            $values[$properties[$i]] = $_POST[$properties[$i]];

        }
        $values[$properties[count($properties)-2]] = date('Y-m-d H:i:s');
        $values[$id_name] = $id;
        return $values;
    }
    public function insertString()
    {
        $properties = $this->getProperties();
        $str = "(";
        for ($i = 0; $i <count($properties)-2; $i++) {
            $str = $str . $properties[$i] . ",";
        }
        $str = $str . $properties[count($properties)-2] . ") VALUES (";
        for ($i = 0; $i <count($properties)-2; $i++) {
            $str = $str . ":" . $properties[$i] . ",";
        }
        $str = $str . ":" . $properties[count($properties)-2] . ")";
        return $str;
    }

    public function insertValues() 
    {
        $properties = $this->getProperties();
        $values = [];
        for ($i = 0; $i <count($properties)-3; $i++) {
            $values[$properties[$i]] = $_POST[$properties[$i]];
        }
        $values[$properties[count($properties)-3]] = date('Y-m-d H:i:s');
        $values[$properties[count($properties)-2]] = date('Y-m-d H:i:s');
        return $values;
    }
}
?>
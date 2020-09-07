<?php
namespace AHT\Models;

use AHT\Core\Model;

class Task extends Model
{
    private $title;
    private $description;
    private $created_at;
    private $updated_at;
    private $id;

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getCreated_at()
    {
        return $this->created_at;
    }

    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->$id;
    }

    public function __set($key, $value){
        $this->$key = $value;
    }

    public function __get($key){
        if (property_exists($this, $key)) {
            return $this->$key;
        } else {
            die('Không tồn tại thuộc tính');
        }
    }
}
?>
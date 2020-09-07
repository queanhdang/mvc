<?php
namespace AHT\Models;

use AHT\Config\Database;
use AHT\Models\Task;
use AHT\Core\ResourceModel;
use PDO;

use ReflectionClass;
class TaskResourceModel extends ResourceModel
{
    public function __construct($table, $id, $model)
    {
        $this->__init($table, $id, $model);
    }
    
    public function showAll($model)
    {
        $class_name = get_class($model);
        $sql  = "SELECT * FROM " . $this->table;
        $req = Database::getBdd()->prepare($sql);
        $req->execute();
        $array_obj=[];
        $array = $req->fetchAll();
        for ($i = 0; $i <count($array); $i++) {
            $task = new $class_name;
            foreach ($array[$i] as $key => $value) {
                $task->$key = $value;
            }
            array_push($array_obj, $task);
        }
        return $array_obj;
    }
    
    //done
    public function show($id)
    {
        $class_name = get_class($this->model);
        $model = new $class_name;
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->id . " = " . $id;
        $req = Database::getBdd()->prepare($sql);
        $req->execute();
        foreach ($req->fetch(PDO::FETCH_ASSOC) as $key => $value) {
            $model->$key = $value;
        }
        return $model;
    }
    
    public function delete($model)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE " . $this->id . " =:" . $this->id;
        echo $sql;
        $req = Database::getBdd()->prepare($sql);
        return $req->execute([$this->id => $model->id]);
    }
    
    public function edit($model)
    {
        $params = [];
        $properties = $model->getProperties();
        $str = "";

        for ($i = 0; $i < count($properties); $i++) {
            if ($properties[$i] != $this->id && $properties[$i] != "created_at") {
                $params[$properties[$i]] = $model->{$properties[$i]};
                $str = $str . $properties[$i] . "=:" . $properties[$i] . ",";
            }
        }
        $params[$this->id] = $model->id;
        $str = substr($str, 0, strlen($str)-1);
        print_r($params);
        $sql = "UPDATE " . $this->table . " SET " . $str. " WHERE " . $this->id . " = :" . $this->id;
        echo $sql;
        $req = Database::getBdd()->prepare($sql);
        return $req->execute($params);
    }

    public function create($model)
    {
        $properties = $model->getProperties();
        $str1 = "";
        $str2 = "";
        for ($i = 0; $i < count($properties); $i++) {
            if ($properties[$i] != $this->id) {
                $str1.=  $properties[$i] . ",";
                $str2.=  ":" . $properties[$i] . ","; 
            }
        }
        $str1 = substr($str1, 0, strlen($str1)-1);
        $str2 = substr($str2, 0, strlen($str2)-1);
        $params = [];
        for ($i = 0; $i < count($properties); $i++) {
            if ($properties[$i] != $this->id) {
                $params[$properties[$i]] = $model->{$properties[$i]};
            }
        }
        $sql = "INSERT INTO " . $this->table . " (" . $str1 . ") VALUES (" .$str2 . ")";
        echo $sql;
        $req = Database::getBdd()->prepare($sql);
        return $req->execute($params);
    }
}

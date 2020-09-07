<?php
namespace AHT\Models;

use AHT\Config\Database;
use AHT\Models\Task;
use AHT\Core\ResourceModel;

use ReflectionClass;
class TaskResourceModel extends ResourceModel
{
    public function __construct($table, $id, $model)
    {
        $this->__init($table, $id, $model);
    }
    
    public function showAll()
    {
        $sql  = "SELECT * FROM " . $this->table;
        $req = Database::getBdd()->prepare($sql);
        $req->execute();
        $array_obj=[];
        $array = $req->fetchAll();
        for ($i = 0; $i <count($array); $i++) {
            $task = new $this->model;
            foreach ($array[$i] as $key => $value) {
                $task->$key = $value;
            }
            array_push($array_obj, $task);
        }
        return $array_obj;
    }
    
    public function show($id)
    {
        $model = new $this->model;
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->id . " = " . $id;
        $req = Database::getBdd()->prepare($sql);
        $req->execute();
        foreach ($req->fetch() as $key => $value) {
            $model->$key = $value;
        }
        return $model;
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE " . $this->id . " = " . $id;
        echo $sql;
        $req = Database::getBdd()->prepare($sql);
        return $req->execute();
    }
    
    public function edit($id)
    {
        $t = new $this->model;
        $sql = "UPDATE " . $this->table . " SET " . $t->updateString(). " WHERE " . $this->id . " = :" . $this->id;
        $req = Database::getBdd()->prepare($sql);
        return $req->execute($t->updateValues($this->id, $id));
    }

    public function create()
    {
        $t = new $this->model;
        $sql = "INSERT INTO " . $this->table . $t->insertString();
        $req = Database::getBdd()->prepare($sql);
        return $req->execute($t->insertValues());
    }
}

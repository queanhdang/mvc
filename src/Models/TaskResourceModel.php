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
        return $req->fetchAll();
    }
    
    public function show($id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->id . " = " . $id;
        $req = Database::getBdd()->prepare($sql);
        $req->execute();
        return $req->fetch();
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
        $sql = "UPDATE " . $this->table . " SET " . $this->model->updateString(). " WHERE " . $this->id . " = :" . $this->id;
        $req = Database::getBdd()->prepare($sql);
        return $req->execute($this->model->updateValues($this->id, $id));
    }

    public function create()
    {
        $sql = "INSERT INTO " . $this->table . $this->model->insertString();
        $req = Database::getBdd()->prepare($sql);
        return $req->execute($this->model->insertValues());
    }
}

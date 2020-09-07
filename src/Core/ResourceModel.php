<?php
namespace AHT\Core;
use AHT\Core\ResourceModelInterface;

class ResourceModel implements ResourceModelInterface
{
    // protected $table;
    // protected $id;
    // protected $model;
    public function __init($table, $id, $model)
    {
        $this->table = $table;
        $this->id = $id;
        $this->model = $model;
    }
    public function save($model)
    {
        $sql = "UPDATE " . $this->table . " SET " . $this->model->updateString(). " WHERE " . $this->id . " = :" . $this->id;
        $req = Database::getBdd()->prepare($sql);
        return $req->execute($this->model->updateValues($this->id, $id));
    }
    public function delete($model)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE " . $this->id . " = " . $id;
        echo $sql;
        $req = Database::getBdd()->prepare($sql);
        return $req->execute();
    }

}
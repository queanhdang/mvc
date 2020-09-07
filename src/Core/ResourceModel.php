<?php
namespace AHT\Core;
use AHT\Core\ResourceModelInterface;

class ResourceModel implements ResourceModelInterface
{
    protected $table;
    protected $id;
    protected $model;
    public function __init($table, $id, $model)
    {
        $this->table = $table;
        $this->id = $id;
        $this->model = $model;
    }
    public function save($model)
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
    public function delete($model)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE " . $this->id . " =:" . $this->id;
        echo $sql;
        $req = Database::getBdd()->prepare($sql);
        return $req->execute([$this->id => $model->id]);
    }

}
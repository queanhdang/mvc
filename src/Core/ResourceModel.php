<?php
namespace AHT\Core;
use AHT\Core\ResourceModelInterface;
use AHT\Config\Database;
use PDO;

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
        if ($model->id == null) {
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
            // echo $sql;
            $req = Database::getBdd()->prepare($sql);
            return $req->execute($params);
        } else {
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
            $sql = "UPDATE " . $this->table . " SET " . $str. " WHERE " . $this->id . " = :" . $this->id;
            $req = Database::getBdd()->prepare($sql);
            return $req->execute($params);
        }
    }

    public function delete($model)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE " . $this->id . " =:" . $this->id;
        echo $sql;
        $req = Database::getBdd()->prepare($sql);
        return $req->execute([$this->id => $model->id]);
    }

    public function get($id = null)
    {   
        $class_name = get_class($this->model);
        if ($id == null) {
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
        } else {
            $model = new $class_name;
            $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->id . " = " . $id;
            $req = Database::getBdd()->prepare($sql);
            $req->execute();
            foreach ($req->fetch(PDO::FETCH_ASSOC) as $key => $value) {
                $model->$key = $value;
            }
            return $model;
        }
    }
}
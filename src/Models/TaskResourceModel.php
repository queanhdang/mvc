<?php
namespace AHT\Models;

use AHT\Models\Task;
use AHT\Core\ResourceModel;


use ReflectionClass;
class TaskResourceModel extends ResourceModel
{
    public function __construct($table, $id, $model)
    {
        $this->__init($table, $id, $model);
    }
    
    public function showAll($model)
    {
        return $this->get();
    }
    
    //done
    public function show($id)
    {
        return $this->get($id);
    }
    
    public function delete($model)
    {
        return parent::delete($model);
    }
    
    public function edit($model)
    {
        return $this->save($model);
    }

    public function create($model)
    {
        return $this->save($model);
    }
}

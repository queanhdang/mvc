<?php
namespace AHT\Core;

interface ResourceModelInterface
{
    public function __init($table, $id, $model);
    public function save($model);
    public function delete($model);
    public function get($id = null);
}
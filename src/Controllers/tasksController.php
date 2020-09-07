<?php
namespace AHT\Controllers;

use AHT\Models\TaskResourceModel;
use AHT\Core\Controller;
use AHT\Models\Task;

class tasksController extends Controller
{
    function index1()
    {
        // $task = new Task();
        $taskResourceModel = new TaskResourceModel("tasks", "id", "AHT\Models\Task");

        $d['tasks'] = $taskResourceModel->showAll();
        $this->set($d);
        $this->render("index1");
    }

    function create()
    {
        if (isset($_POST["title"]))
        {
            $task= new Task();
            $taskResourceModel = new TaskResourceModel("tasks", "id", "AHT\Models\Task");
            if ($taskResourceModel->create())
            {
                header("Location: " . WEBROOT . "tasks/index1");
            }
        }

        $this->render("create");
    }

    function edit($id)
    {
        $task= new Task();
        $taskResourceModel = new TaskResourceModel("tasks", "id", "AHT\Models\Task");
        $d["task"] = $taskResourceModel->show($id);
        if (isset($_POST["title"]))
        {
            if ($taskResourceModel->edit($id))
            {
                header("Location: " . WEBROOT . "tasks/index1");
            }
        }
        $this->set($d);
        $this->render("edit");
    }

    function delete($id)
    {
        $task = new Task();
        $taskResourceModel = new TaskResourceModel("tasks", "id", $task);
        if ($taskResourceModel->delete($id))
        {
            header("Location: " . WEBROOT . "tasks/index1");
        }
    }
}
?>
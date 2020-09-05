<?php
namespace AHT\Controllers;

use AHT\Core\Controller;
use AHT\Models\Task;

class tasksController extends Controller
{
    function index1()
    {
        $tasks = new Task();

        $d['tasks'] = $tasks->showAllTasks();
        $this->set($d);
        $this->render("index1");
    }

    function create()
    {
        if (isset($_POST["title"]))
        {
            $task= new Task();

            if ($task->create($_POST["title"], $_POST["description"]))
            {
                header("Location: " . WEBROOT . "tasks/index1");
            }
        }

        $this->render("create");
    }

    function edit($id)
    {
        $task= new Task();

        $d["task"] = $task->showTask($id);

        if (isset($_POST["title"]))
        {
            if ($task->edit($id, $_POST["title"], $_POST["description"]))
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
        if ($task->delete($id))
        {
            header("Location: " . WEBROOT . "tasks/index1");
        }
    }
}
?>
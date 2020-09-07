<?php
namespace AHT\Controllers;

use AHT\Models\TaskResourceModel;
use AHT\Core\Controller;
use AHT\Models\Task;

class tasksController extends Controller
{
    function index1()
    {
        $task = new Task();
        $taskResourceModel = new TaskResourceModel("tasks", "id", $task);

        $d['tasks'] = $taskResourceModel->showAll($task);
        $this->set($d);
        $this->render("index1");
    }

    function create()
    {
        if (isset($_POST["title"]))
        {
            $task = new Task();
            $task->title = $_POST['title'];
            $task->description = $_POST['description'];
            $task->created_at = date('Y-m-d H:i:s');
            $task->updated_at = date('Y-m-d H:i:s');
            $taskResourceModel = new TaskResourceModel("tasks", "id", $task);
            if ($taskResourceModel->create($task))
            {
                header("Location: " . WEBROOT . "tasks/index1");
            }
        }

        $this->render("create");
    }

    function edit($id)
    {
        $task = new Task();
        $taskResourceModel = new TaskResourceModel("tasks", "id", $task);
        $d["task"] = $taskResourceModel->show($id);
        $task = $taskResourceModel->show($id);
        
        if (isset($_POST["title"]))
        {
            $task->title = $_POST['title'];
            $task->description = $_POST['description'];
            $task->updated_at = date('Y-m-d H:i:s');
            // $model = [
            //     "id" => $task->id,
            //     "title" => $_POST['title'],
            //     "description" => $_POST['description'],
            //     "updated_at" => date('Y-m-d H:i:s')
            // ];
            if ($taskResourceModel->edit($task))
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
        // $model =[
        //     "id" => $id
        // ];
        $task->id = $id;
        $taskResourceModel = new TaskResourceModel("tasks", "id", $task);
        if ($taskResourceModel->delete($task))
        {
            header("Location: " . WEBROOT . "tasks/index1");
        }
    }
}
?>
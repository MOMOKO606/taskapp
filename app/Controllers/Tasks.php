<?php

namespace App\Controllers;

use App\Entities\Task;
use http\Env\Request;

class Tasks extends BaseController
{
    public function __construct()
    {
        $this -> model = new \App\Models\TaskModel;
    }


    public function getIndex()
    {

        $data = $this -> model -> findAll();

        return view("Tasks/index", ['tasks' => $data ]);
    }


    public function getShow($id){

        $task = $this -> getTaskOr404($id);

        return view("Tasks/show", ['task' => $task ]);
    }

    public function getNew(){
        $task = new Task;

        return view("Tasks/new", [
            "task" => $task
        ]);
    }

    public function postCreate(){
        $model = new \App\Models\TaskModel;

        $task = new Task($this -> request -> getPost() );

        if ($this -> model -> insert($task)){
            return redirect() -> to("tasks/show/{$this -> model -> insertID}")
                -> with("info", "Task created successfully");
        }else{
            return redirect() -> back()
                -> with("errors", $model -> errors())
                -> with("warning", "Invalid data")
                -> withInput();
        }
    }

    public function getEdit($id){

        $task = $this -> getTaskOr404($id);

        return view("tasks/edit", ["task" => $task]);
    }

    public function postUpdate($id){

//        $result = $model -> update($id, [
//           "description" => $this -> request -> getPost("description")
//        ]);

        $task = $this -> getTaskOr404($id);

        $task -> fill($this -> request -> getPost());

        if( !$task -> hasChanged()){
            return redirect() -> back()
                -> with("error", $this -> model -> errors())
                -> with("warning", "Nothing to update")
                -> withInput();
        }

        if ( $this -> model -> save($task)){
            return redirect() -> to("/tasks/show/$id")
                -> with("info", "Task updated successfully!");
        }else{
            return redirect() -> back()
                              -> with("warning", "Invalid data")
                              -> withInput();
        }
    }

    private function getTaskOr404($id){
        $task = $this -> model -> find( $id );

        if ($task == null){
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Task with id $id not found");
        }

        return $task;
    }
}
<?php

namespace App\Controllers;

use App\Entities\Task;
use http\Env\Request;

class Tasks extends BaseController
{
    public function getIndex()
    {
        $model = new \App\Models\TaskModel;

        $data = $model -> findAll();

        return view("Tasks/index", ['tasks' => $data ]);
    }


    public function getShow($id){

        $model = new \App\Models\TaskModel;

        $data = $model -> find( $id );

        return view("Tasks/show", ['task' => $data ]);
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

        if ($model -> insert($task)){
            return redirect() -> to("tasks/show/{$model -> insertID}")
                -> with("info", "Task created successfully");
        }else{
            return redirect() -> back()
                -> with("errors", $model -> errors())
                -> with("warning", "Invalid data")
                -> withInput();
        }
    }

    public function getEdit($id){
        $model = new \App\Models\TaskModel;

        $task = $model -> find($id);

        return view("tasks/edit", ["task" => $task]);
    }

    public function postUpdate($id){
        $model = new \App\Models\TaskModel;

//        $result = $model -> update($id, [
//           "description" => $this -> request -> getPost("description")
//        ]);

        $task = $model -> find($id);

        $task -> fill($this -> request -> getPost());

        if( !$task -> hasChanged()){
            return redirect() -> back()
                -> with("error", $model -> errors())
                -> with("warning", "Nothing to update")
                -> withInput();
        }

        if ( $model -> save($task)){
            return redirect() -> to("/tasks/show/$id")
                -> with("info", "Task updated successfully!");
        }else{
            return redirect() -> back()
                              -> with("warning", "Invalid data")
                              -> withInput();
        }
    }
}
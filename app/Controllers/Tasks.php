<?php

namespace App\Controllers;

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
        return view("Tasks/new", [
            "task" => ["description" => ""]
        ]);
    }

    public function postCreate(){
        $model = new \App\Models\TaskModel;

        $result = $model -> insert([
            "description" => $this -> request -> getPost("description")
        ]);

        if ($result === false){
            return redirect() -> back()
                              -> with("errors", $model -> errors())
                              -> with("warning", "Invalid data")
                              -> withInput();
        }else{
            return redirect() -> to("tasks/show/$result")
                              -> with("info", "Task created successfully");
        }
    }

    public function getEdit($id){
        $model = new \App\Models\TaskModel;

        $task = $model -> find($id);

        return view("tasks/edit", ["task" => $task]);
    }

    public function postUpdate($id){
        $model = new \App\Models\TaskModel;

        $result = $model -> update($id, [
           "description" => $this -> request -> getPost("description")
        ]);

        if ($result){
            return redirect() -> to("/tasks/show/$id")
                -> with("info", "Task updated successfully!");
        }else{
            return redirect() -> back()
                              -> with("error", $model -> errors())
                              -> with("warning", "Invalid data")
                              -> withInput();
        }
    }
}
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
}
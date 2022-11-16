<?php

namespace App\Controllers;

use App\Entities\Task;
use http\Env\Request;

class Tasks extends BaseController
{
    private $model;

    private $current_user;

    public function __construct()
    {
        $this->model = new \App\Models\TaskModel;
        $this->current_user = service("auth")->getCurrentUser();
    }


    public function getIndex()
    {
        $data = $this->model->paginateTasksByUserId($this->current_user->id);

        return view("Tasks/index", [
            'tasks' => $data,
            //  分页传入。
            'pager' => $this ->model->pager]);
    }


    public function getShow($id)
    {

        $task = $this->getTaskOr404($id);

        return view("Tasks/show", ['task' => $task]);
    }

    public function getNew()
    {
        $task = new Task;

        return view("Tasks/new", [
            "task" => $task
        ]);
    }

    public function postCreate()
    {
        $task = new Task($this->request->getPost());


        $task->user_id = $this->current_user->id;

        if ($this->model->insert($task)) {
            return redirect()->to("tasks/show/{$this -> model -> insertID}")
                ->with("info", "Task created successfully");
        } else {
            return redirect()->back()
                ->with("errors", $model->errors())
                ->with("warning", "Invalid data")
                ->withInput();
        }
    }

    public function getEdit($id)
    {

        $task = $this->getTaskOr404($id);

        return view("tasks/edit", ["task" => $task]);
    }

    public function postUpdate($id)
    {
//     不用Entity， 直接对model中的row进行操作的方法。
//        $result = $model -> update($id, [
//           "description" => $this -> request -> getPost("description")
//        ]);

        $task = $this->getTaskOr404($id);

//      安全性Sentinel，如果post进来的数据有user_id就直接删除。
        $post = $this->request->getPost();
        unset($post["user_id"]);

        $task->fill($post);

        if (!$task->hasChanged()) {
            return redirect()->back()
                ->with("error", $this->model->errors())
                ->with("warning", "Nothing to update")
                ->withInput();
        }

        if ($this->model->save($task)) {
            return redirect()->to("/tasks/show/$id")
                ->with("info", "Task updated successfully!");
        } else {
            return redirect()->back()
                ->with("warning", "Invalid data")
                ->withInput();
        }
    }


    public function getDelete($id)
    {
        $task = $this->getTaskOr404($id);

        return view("Tasks/delete", ["task" => $task]);

    }

    public function postDelete($id)
    {
        $task = $this->getTaskOr404($id);

        $this->model->delete($id);

        return redirect()->to('/tasks')
            ->with('info', 'Task deleted');
    }

    public function getSearch()
    {   //  调用taskmodel中的函数来搜索task
        $tasks = $this->model->search($this->request->getGet('q'), $this->current_user->id);
        //  将查到的结果返回为JSON
        return $this->response->setJSON($tasks);


    }


    private function getTaskOr404($id)
    {
        /*
        $task = $this->model->find($id);

        if ($task !== null && ($task->user_id !== $user->id)) {

            $task = null;

        }
        */

        $task = $this->model->getTaskByUserId($id, $this->current_user->id);

        if ($task === null) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException("Task with id $id not found");

        }

        return $task;
    }




}
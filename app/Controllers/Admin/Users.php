<?php

namespace App\Controllers\Admin;
//  此处extends 完整路径+名是因为
//  如果extends BaseController编译器会在namespace下查找，
//  即导致not found
class Users extends \App\Controllers\BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\UserModel;
    }

    public function getIndex()
    {
        //  得到以id排序的user列表，且每页显示5条。
        $users = $this->model->orderBy('id')
            ->paginate(5);
        //  将user数据和分页信息传到前端。
        return view('Admin/Users/index', [
            'users' => $users,
            'pager' => $this->model->pager
        ]);
    }

    public function getShow($id)
    {
        $user = $this->getUserOr404($id);

        return view('Admin/Users/show', [
            'user' => $user
        ]);
    }

    private function getUserOr404($id)
    {
        $user = $this->model->where('id', $id)
            ->first();

        if ($user === null) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException("User with id $id not found");

        }

        return $user;
    }
}

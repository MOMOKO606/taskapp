<?php

namespace App\Controllers\Admin;
use App\Entities\User;
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

    public function getNew()
    {
        $user = new User;

        return view('Admin/Users/new', [
            'user' => $user
        ]);
    }

    public function postCreate()
    {
        $user = new User($this->request->getPost());

        if ($this->model->insert($user)) {

            return redirect()->to("/admin/users/show/{$this->model->insertID}")
                ->with('info', 'User created successfully');

        } else {

            return redirect()->back()
                ->with('errors', $this->model->errors())
                ->with('warning', 'Invalid data')
                ->withInput();
        }
    }

    public function getEdit($id)
    {
        $user = $this->getUserOr404($id);

        return view('Admin/Users/edit', [
            'user' => $user
        ]);
    }

    public function postUpdate($id)
    {
        $user = $this->getUserOr404($id);

        $post = $this->request->getPost();

        //  检查前端返回的表单中password是否为空。
        if (empty($post['password'])) {
            //  禁用password validation
            $this->model->disablePasswordValidation();
            //  把post中空的password删掉，避免把密码改为了空值。
            unset($post['password']);
            unset($post['password_confirmation']);
        }

        $user->fill($post);

        if ( ! $user->hasChanged()) {

            return redirect()->back()
                ->with('warning', 'Nothing to update')
                ->withInput();
        }

        if ($this->model->save($user)) {

            return redirect()->to("/admin/users/show/$id")
                ->with('info', 'User updated successfully');

        } else {

            return redirect()->back()
                ->with('errors', $this->model->errors())
                ->with('warning', 'Invalid data')
                ->withInput();

        }
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

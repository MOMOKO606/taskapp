<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function getNew()
    {
        return view('Login/new');
    }

    public function postCreate()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model = new \App\Models\UserModel;

        $user = $model->where('email', $email)
            ->first();

        if ($user === null) {

            return redirect()->back()
                ->withInput()
                ->with('warning', 'User not found');

        } else {

            if (password_verify($password, $user->password_hash)) {

                $session = session();
                $session -> set("user_id", $user -> id);
                return redirect() -> to("/")
                                  // flash message，刷新就会消失。
                                  -> with("info", "Login successful");


            } else {

                return redirect()->back()
                    ->withInput()
                    ->with('warning', 'Incorrect password');
            }
        }
    }

    public function getDelete()
    {
        session()->destroy();

        return redirect()->to('/login/showLogoutMessage');
    }
}


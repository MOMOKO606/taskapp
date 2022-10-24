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

        $auth = service("auth");

        if ($auth -> login($email, $password)){
            return redirect() -> to("/")
                // flash message，刷新就会消失。
                -> with("info", "Login successful");

        }else{
            return redirect()->back()
                ->withInput()
                ->with('warning', 'Invalid login');

        }
    }

    public function getDelete()
    {
        session()->destroy();

        return redirect()->to('/login/showLogoutMessage');
    }
}


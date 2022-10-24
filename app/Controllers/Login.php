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
            //  从session中取得先前url, 如果值为空则取首页，存放在$redirect_url中
            $redirect_url = session('redirect_url') ?? '/';
            //  释放session中的url信息。
            unset($_SESSION['redirect_url']);
            //  登录成功后跳转回$redirect_url
            return redirect()->to($redirect_url)
                ->with('info', 'Login successful');

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


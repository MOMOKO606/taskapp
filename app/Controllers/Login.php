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
        $remember_me = (bool)$this->request->getPost('remember_me');


        $auth = service("auth");

        if ($auth -> login($email, $password, $remember_me)){
            //  从session中取得先前url, 如果值为空则取首页，存放在$redirect_url中
            $redirect_url = session('redirect_url') ?? '/';
            //  释放session中的url信息。
            unset($_SESSION['redirect_url']);
            //  登录成功后跳转回$redirect_url
            return redirect()->to($redirect_url)
                ->with('info', lang('Login.successful'))
                ->withCookies();

        }else{
            return redirect()->back()
                ->withInput()
                ->with('warning', lang('Login.invalid'));

        }
    }


    public function getDelete()
    {
        service("auth") ->logout();
        return redirect()->to('/showLogoutMessage')
                         ->withCookies();
    }


    public function getShowLogoutMessage()
    {
        return redirect()->to('/')
            ->with('info', lang('Login.logout_successful'));
    }
}


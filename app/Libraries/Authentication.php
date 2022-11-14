<?php

namespace App\Libraries;

class Authentication
{
    // 初值为null的cache。
    private $user;

    public function login($email, $password, $remember_me)
    {
        $model = new \App\Models\UserModel;

        //  这句可以更清晰一些，即把数据库的操作全放在model中，我们通过调用model中的function来得到想要的结果。
//        $user = $model->where('email', $email)
//            ->first();
        //  $user其实是table的一行，即它是一个Entity/User的实例。
        $user = $model -> findByEmail($email);

        if ($user === null) {

            return false;

        }

        if ( ! $user -> verifyPassWord($password) ) {

            return false;

        }

        if ( ! $user->is_active) {

            return false;

        }

        $this->logInUser($user);

        //  用户账号密码没问题，且选中了remember me，则我们要创建remember me的token
        if ($remember_me) {

            $this->rememberLogin($user->id);

        }

        return true;
    }

    private function rememberLogin($user_id)
    {
        $model = new \App\Models\RememberedLoginModel;

        list($token, $expiry) = $model->rememberUserLogin($user_id);

        //  把创建的remember me token发给用户cookie。
        //  通过response helper类实现set cookie。
        $response = service('response');

        $response->setCookie('remember_me', $token, $expiry);
    }

    public function logout()
    {
        //  首先检查cookie
        $token = service('request')->getCookie('remember_me');

        if ($token !== null) {

            $model = new \App\Models\RememberedLoginModel;
            //  删除数据库中的token
            $model->deleteByToken($token);
        }
        //  删除cookie
        service('response')->deleteCookie('remember_me');
        //  删除session
        session()->destroy();
    }

    private function getUserFromSession()
    {
        if ( ! session()->has('user_id')) {

            return null;

        }

        $model = new \App\Models\UserModel;

        $user = $model->find(session()->get('user_id'));

        if ($user && $user->is_active) {

            return $user;
        }
    }

    private function getUserFromRememberCookie()
    {
        $request = service('request');

        $token = $request->getCookie('remember_me');

        if ($token === null) {

            return null;
        }

        $remembered_login_model = new \App\Models\RememberedLoginModel;

        $remembered_login = $remembered_login_model->findByToken($token);

        if ($remembered_login === null) {

            return null;
        }

        $user_model = new \App\Models\UserModel;

        $user = $user_model->find($remembered_login['user_id']);

        if ($user && $user->is_active) {

            $this->logInUser($user);

            return $user;
        }
    }

    public function getCurrentUser()
    {
        //  先查session
        if ($this->user === null) {

            $this->user = $this->getUserFromSession();
        }

        //  再查cookie
        if ($this->user === null) {

            $this->user = $this->getUserFromRememberCookie();
        }

        return $this->user;
    }

    private function logInUser($user)
    {
        $session = session();
        $session->regenerate();
        $session->set('user_id', $user->id);
    }

    public function isLoggedIn()
    {
        return $this->getCurrentUser() !== null;
    }
}


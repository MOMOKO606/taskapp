<?php

namespace App\Libraries;

class Authentication
{
    // 初值为null的cache。
    private $user;

    public function login($email, $password)
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

        $session = session();
        $session->regenerate();
        $session->set('user_id', $user->id);

        return true;
    }

    public function logout()
    {
        session()->destroy();
    }

    public function getCurrentUser()
    {
        if ( ! session()->has('user_id')) {

            return null;

        }

        if ($this->user === null) {

            $model = new \App\Models\UserModel;

            $this->user = $model->find(session()->get('user_id'));
        }

        return $this->user;
    }
}


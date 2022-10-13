<?php

namespace App\Controllers;

class Signup extends BaseController{

    public function getNew(){
        return view("Signup/new");
    }

    public function postCreate(){
        //  把前段post的数据写入Entity实例
        $user = new \App\Entities\User($this->request->getPost());

        //  建立数据库实例；
        $model = new \App\Models\UserModel;

        //  把Entity实例插入数据库实例。
        $model->insert($user);

        echo "Signed up";

    }

}

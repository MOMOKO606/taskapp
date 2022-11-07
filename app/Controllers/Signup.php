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

        //  生成token：随机的16位bytes，并用hex进制表示
        $token = bin2hex(random_bytes(16));
        //  对$token用'sha256'算法 和 key进行hash
        //  注意key是一个常量，类似于配置，所以要存放到.env中。
        $hash = hash_hmac('sha256', $token, $_ENV['HASH_SECRET_KEY']);
        dd($hash);

        //  把Entity实例插入数据库实例。
        //  如果插入成功$sentinel为真，否则为假。
        $sentinel = $model->insert($user);

        if ($sentinel) {

            // 注意习惯，一般post完之后都喜欢跳转到另一界面。
            // 如果直接return到view，则你的url不会发生跳转，是不变的。
            // 而先return到controller再，从controller跳到view，则url会跳转。
            return redirect() -> to("/signup/success");

        } else {

            return redirect()->back()
                ->with('errors', $model->errors())
                ->with('warning', 'Invalid data')
                ->withInput();
        }
    }

    public function getSuccess(){
        return view("Signup/success");
    }

}

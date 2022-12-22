<?php

namespace App\Controllers;

class Signup extends BaseController{

    public function getNew(){
        return view("/Signup/new");
    }

    public function postCreate(){
        //  把前段post的数据写入Entity实例
        $user = new \App\Entities\User($this->request->getPost());

        //  建立数据库实例；
        $model = new \App\Models\UserModel;

        //  生成token并hash。
        $user->startActivation();

        //  把Entity实例插入数据库实例。
        //  如果插入成功$sentinel为真，否则为假。
        $sentinel = $model->insert($user);

        if ($sentinel) {
            $this->sendActivationEmail($user);

            // 注意习惯，一般post完之后都喜欢跳转到另一界面。
            // 如果直接return到view，则你的url不会发生跳转，是不变的。
            // 而先return到controller再，从controller跳到view，则url会跳转。
            return redirect() -> to("/signup/success");

        } else {

            return redirect()->back()
                ->with('errors', $model->errors())
                ->with('warning', lang('App.messages.invalid'))
                ->withInput();
        }
    }

    public function getSuccess(){
        return view("Signup/success");
    }

    private function sendActivationEmail($user)
    {
        $email = service('email');

        $email->setTo($user->email);

        $email->setSubject('Account activation');

        //  即发出的邮件内容是个html文件，存放在views/Signup/activation_email
        $message = view('Signup/activation_email', [
            'token' => $user->token
        ]);

        $email->setMessage($message);

        $email->send();
    }

    public function getActivate($token)
    {
        $model = new \App\Models\UserModel;

        $model->activateByToken($token);

        return view('Signup/activated');
    }


}

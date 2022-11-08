<?php

namespace App\Controllers;

class Password extends BaseController
{
    public function getForgot()
    {
        return view('Password/forgot');
    }

    public function postProcessForgot()
    {
        $model = new \App\Models\UserModel;

        $user = $model->findByEmail($this->request->getPost('email'));

        if ($user && $user->is_active) {
            //  当用户是合法存在时，开始password reset程序
            //  从Entity实例中新建 reset_hash 和 reset_expires_at，并存入行
            $user->startPasswordReset();
            //  将行存入table
            $model->save($user);

            $this->sendResetEmail($user);

            return redirect()->to("/password/resetsent");

        } else {

            return redirect()->back()
                ->with('warning', 'No active user found with that email address')
                ->withInput();
        }
    }

    public function getResetSent()
    {
        return view('Password/reset_sent');
    }

    private function sendResetEmail($user)
    {
        $email = service('email');

        $email->setTo($user->email);

        $email->setSubject('Password reset');

        $message = view('Password/reset_email', [
            'token' => $user->reset_token
        ]);

        $email->setMessage($message);

        $email->send();
    }
}

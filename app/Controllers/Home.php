<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view("Home/index");
//        return view('welcome_message');
    }


    public function getTestemail()
    {
        $email = \Config\Services::email();
        $email->setFrom('0618bianlong@gmail.com', 'Task application');

        $email->setTo('bianlong0618@qq.com');

        $email->setSubject('A test email');

        $email->setMessage('<h1>Hello world</h1>');

        if ($email->send()) {

            echo "Message sent";

        } else {

            echo $email->printDebugger();

        }
    }


}

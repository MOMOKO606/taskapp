<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function getNew()
    {
        return view('Login/new');
    }
}
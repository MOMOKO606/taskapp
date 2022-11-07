<?php

namespace App\Controllers;

class Password extends BaseController
{
    public function getForgot()
    {
        return view('Password/forgot');
    }
}

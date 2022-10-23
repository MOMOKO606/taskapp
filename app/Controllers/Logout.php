<?php

namespace App\Controllers;

class Logout extends BaseController
{
    public function getDelete()
    {
        $auth = new \App\Libraries\Authentication;

        $auth->logout();

        return redirect()->to('/logout/showLogoutMessage');
    }

    public function getShowLogoutMessage()
    {
        return redirect()->to('/')
            ->with('info', 'Logout successful');
    }
}


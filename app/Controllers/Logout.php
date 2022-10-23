<?php

namespace App\Controllers;

class Logout extends BaseController
{
    public function getDelete()
    {
        session()->destroy();

        return redirect()->to('/logout/showLogoutMessage');
    }

    public function getShowLogoutMessage()
    {
        return redirect()->to('/')
            ->with('info', 'Logout successful');
    }
}


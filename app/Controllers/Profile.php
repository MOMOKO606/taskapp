<?php

namespace App\Controllers;

class Profile extends BaseController
{
    public function getShow()
    {
        $user = service('auth')->getCurrentUser();

        return view('Profile/show', [
            'user' => $user
        ]);
    }
}

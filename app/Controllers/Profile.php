<?php

namespace App\Controllers;

class Profile extends BaseController
{
    private $user;

    public function __construct()
    {
        $this->user = service('auth')->getCurrentUser();
    }

    public function getShow()
    {
        return view('Profile/show', [
            'user' => $this->user
        ]);
    }

    public function getEdit()
    {
        return view('Profile/edit', [
            'user' => $this->user
        ]);
    }
}
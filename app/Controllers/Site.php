<?php

namespace App\Controllers;

class Site extends BaseController
{
    public function getAboutUs()
    {
        $data = [
            ['id' => 1, 'description' => 'First task'],
            ['id' => 2, 'description' => 'Second task']
        ];
        return view("Site/about-us", ['tasks' => $data ]);
    }
}
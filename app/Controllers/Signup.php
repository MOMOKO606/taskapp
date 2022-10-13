<?php

namespace App\Controllers;

class Signup extends BaseController{

    public function getNew(){
        return view("Signup/new");
    }

}

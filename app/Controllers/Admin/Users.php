<?php

namespace App\Controllers\Admin;
//  此处extends 完整路径+名是因为
//  如果extends BaseController编译器会在namespace下查找，
//  即导致not found
class Users extends \App\Controllers\BaseController
{
    public function getIndex()
    {
        return view('Admin/Users/index');
    }
}

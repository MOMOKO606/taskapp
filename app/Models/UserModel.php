<?php

namespace App\Models;

class UserModel extends \CodeIgniter\Model
{
    protected $table = 'user';

    protected $allowedFields = ['name', 'email'];

    // Link this model to the Entity class we made.
    protected $returnType = 'App\Entities\User';

    protected $useTimestamps = true;
}

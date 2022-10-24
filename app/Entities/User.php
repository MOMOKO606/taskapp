<?php

namespace App\Entities;

class User extends \CodeIgniter\Entity\Entity{
    public function verifyPassWord($password){
        return password_verify($password, $this->password_hash);
    }
}
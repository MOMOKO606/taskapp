<?php

namespace App\Entities;

class User extends \CodeIgniter\Entity\Entity{
    public function verifyPassWord($password){

        return password_verify($password, $this->password_hash);

    }

    public function startActivation()
    {
        //  生成token：随机的16位bytes，并用hex进制表示
        $this -> token = bin2hex(random_bytes(16));

        //  对$token用'sha256'算法 和 key进行hash
        //  注意key是一个常量，类似于配置，所以要存放到.env中。
        $this-> activation_hash  = hash_hmac('sha256', $this->token, $_ENV['HASH_SECRET_KEY']);
    }

    public function activate()
    {
        $this->is_active = true;

        //  No longer need the activation_hash.
        $this->activation_hash = null;
    }
}
<?php

namespace App\Libraries;

class Token
{
    private $token;

    public function __construct($token = null)
    {
        if ($token === null) {
            //  生成token：随机的16位bytes，并用hex进制表示
            $this->token = bin2hex(random_bytes(16));

        } else {

            $this->token = $token;

        }
    }

    public function getValue()
    {
        return $this->token;
    }

    public function getHash()
    {
        //  对$token用'sha256'算法 和 key进行hash
        //  注意key是一个常量，类似于配置，所以要存放到.env中。
        return hash_hmac('sha256', $this->token, $_ENV['HASH_SECRET_KEY']);
    }
}

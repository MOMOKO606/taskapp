<?php

namespace App\Entities;

use App\Libraries\Token;

class User extends \CodeIgniter\Entity\Entity{
    public function verifyPassWord($password){

        return password_verify($password, $this->password_hash);

    }

    public function startActivation()
    {
        $token = new Token;

        $this->token = $token->getValue();

        $this->activation_hash = $token->getHash();
    }


    public function activate()
    {
        $this->is_active = true;

        //  No longer need the activation_hash.
        $this->activation_hash = null;
    }

    public function startPasswordReset()
    {
        $token = new Token;

        $this->reset_token = $token->getValue();

        $this->reset_hash = $token->getHash();

        $this->reset_expires_at = date('Y-m-d H:i:s', time() + 7200);
    }
}
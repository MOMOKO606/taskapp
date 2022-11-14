<?php

namespace App\Models;

use App\Libraries\Token;

class RememberedLoginModel extends \CodeIgniter\Model
{
    protected $table = 'remembered_login';

    //  所有的fields都加进来，因为并没有需要用户增删改查的地方，全是有代码进行的。
    protected $allowedFields = ['token_hash', 'user_id', 'expires_at'];

    //  给user创建一个token用来remember login
    public function rememberUserLogin($user_id)
    {
        $token = new Token;

        $token_hash = $token->getHash();

        $expiry = time() + 864000;

        $data = [
            'token_hash' => $token_hash,
            'user_id'    => $user_id,
            'expires_at' => date('Y-m-d H:i:s', $expiry)
        ];
        //  这个function不仅把生成的remember login的token存入database。
        $this->insert($data);
        // 而且返回token和expiry。
        return [
            $token->getValue(),
            $expiry
        ];
    }

    public function findByToken($token)
    {
        $token = new Token($token);

        $token_hash = $token->getHash();

        //  因为没有建立对应的entity，这里旧直接用array。
        //  想用entity也可以
        $remembered_login = $this->where('token_hash', $token_hash)
            ->first();

        if ($remembered_login) {

            if ($remembered_login['expires_at'] > date('Y-m-d H:i:s')) {

                return $remembered_login;
            }
        }
    }


    public function deleteByToken($token)
    {
        $token = new Token($token);

        $token_hash = $token->getHash();

        $this->where('token_hash', $token_hash)
            ->delete();
    }
}

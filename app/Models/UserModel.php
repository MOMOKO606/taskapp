<?php

namespace App\Models;

class UserModel extends \CodeIgniter\Model
{
    protected $table = 'user';

    protected $allowedFields = ['name', 'email', 'password', 'activation_hash'];

    protected $returnType = 'App\Entities\User';

    protected $useTimestamps = true;

    //  其实是对前端POST回来的变量的validation，而不是对database field的validation？
    protected $validationRules = [
        'name' => 'required',
        'email' => 'required|valid_email|is_unique[user.email]',
        'password' => 'required|min_length[6]',
        'password_confirmation' => 'required|matches[password]'
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'That email address is taken'
        ],
        'password_confirmation' => [
            'required' => 'Please confirm the password',
            'matches' => 'Please enter the same password again'
        ]
    ];

    //  表示在插入前执行hashPassword callback函数。
    protected $beforeInsert = ['hashPassword'];

    //  表示在update前执行hashPassword callback函数。
    protected $beforeUpdate = ['hashPassword'];

    //  hashPassword callback函数
    //  $data contains the value from the form.
    protected function hashPassword(array $data)
    {
        //  如果form的传入数据($data)中有password，则对password进行hash；
        //  用default算法进行hash。
        if (isset($data['data']['password'])) {

            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

            //  删掉password，保留password_hash。
            unset($data['data']['password']);
//          捋一捋，databse插入新row时，我们前端需要输入
//          1. password
//          2.确认password
//          但这只是为了安全需要，实际上数据库中不需要“确认password”的信息，且会把“password”，hash完再插入。
//          所以我们在hash的函数中，直接把1 & 2删除即可。
            unset($data['data']['password_confirmation']);
        }

        return $data;
    }

    public function findByEmail($email){
        return $this -> where('email', $email)
                     -> first();
    }

    public function disablePasswordValidation()
    {
        unset($this->validationRules['password']);
        unset($this->validationRules['password_confirmation']);
    }

    public function activateByToken($token)
    {
        $token_hash = hash_hmac('sha256', $token, $_ENV['HASH_SECRET_KEY']);

        $user = $this->where('activation_hash', $token_hash)
            ->first();

        if ($user !== null) {

            //  在entity中activate user。
            $user->activate();

            //  类似password的操作，不能改allowedField，太危险。
            //  所以在此禁用。
            $this->protect(false)
                ->save($user);

        }
    }

}

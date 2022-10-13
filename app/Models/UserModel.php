<?php

namespace App\Models;

class UserModel extends \CodeIgniter\Model
{
    protected $table = 'user';

    protected $allowedFields = ['name', 'email', 'password'];

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
        }

        return $data;
    }
}

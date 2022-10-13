<?php

namespace App\Models;

class UserModel extends \CodeIgniter\Model
{
    protected $table = 'user';

    protected $allowedFields = ['name', 'email', 'password'];

    protected $returnType = 'App\Entities\User';

    protected $useTimestamps = true;

    //  表示在field password插入前执行hashPassword callback函数。
    protected $beforeInsert = ['hashPassword'];

    //  hashPassword callback函数
    //  $data contains the value from the form.
    protected function hashPassword(array $data)
    {
        //  如果form的传入数据($data)中有password，则对password进行hash；
        //  用default算法进行hash。
        if (isset($data['data']['password'])) {

            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

            //  删掉password？
            unset($data['data']['password']);
        }

        return $data;
    }
}

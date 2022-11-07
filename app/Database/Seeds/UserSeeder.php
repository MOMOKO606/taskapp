<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $model = new \App\Models\UserModel;

        $data = [
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'password' => 'secret',
            'is_admin' => true,
            'is_active' => true
        ];
        //  表示在插入前略过validation
        $model->skipValidation(true)
            //  无视model中的allowedfields protected。
            ->protect(false)
            ->insert($data);
        //  如果成功则显示errors为空数组。
        dd($model->errors());
    }
}

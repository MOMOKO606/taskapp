<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\RememberedLoginModel;

class DeleteExpiredRememberedLogins extends BaseCommand
{
    protected $group       = 'Auth';
    //  即在命令行输入的语句。
    protected $name        = 'auth:cleanup';
    protected $description = 'Clears expired remembered login records.';

    public function run(array $params)
    {
        $model = new RememberedLoginModel;

        $rows = $model->deleteExpired();

        echo "$rows rows deleted.\n";
    }
}

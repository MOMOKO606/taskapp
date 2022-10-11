<?php

namespace  App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTimestampsToTask extends Migration
{
    //  Migrate function， such as create table
    public function up()
    {
        $this->forge->addColumn("task", [
            "created_at" => [
                "type"              => "DATETIME",
                "null"              => true,
                "default"           => null,
            ],
            "updated_at" => [
                "type"              => "DATETIME",
                "null"              => true,
                "default"           => null,
            ]
        ]);
    }

    //  Undo the migration.
    public function down()
    {
        $this -> forge -> dropColumn("task", "created_at");
        $this -> forge -> dropColumn("task", "updated_at");
    }
}


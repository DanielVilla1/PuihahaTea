<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCellphoneToUsers extends Migration
{
    public function up()
    {
        // Add 'cellphone' column if it doesn't exist
        $fields = [
            'cellphone' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
                'after'      => 'email',
            ],
        ];
        $this->forge->addColumn('users', $fields);
        // Index creation is optional; skipping for portability
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'cellphone');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCustomerAuthFields extends Migration
{
    public function up()
    {
        // Add password_hash, verification_token, verified_at, token_sent_at
        $fields = [
            'password_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'email',
            ],
            'verification_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 128,
                'null'       => true,
                'after'      => 'password_hash',
            ],
            'token_sent_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'verification_token',
            ],
            'verified_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'token_sent_at',
            ],
        ];
        $this->forge->addColumn('customers', $fields);
        $this->forge->addKey('verification_token');
    }

    public function down()
    {
        $this->forge->dropColumn('customers', ['password_hash', 'verification_token', 'token_sent_at', 'verified_at']);
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'customer_name' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
                'null' => true,
            ],
            'items' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'JSON-encoded items summary',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
                'default' => 'pending',
            ],
            'assigned_to' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'User ID of staff/manager handling the order',
            ],
            'total' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('orders', true);
    }

    public function down()
    {
        $this->forge->dropTable('orders', true);
    }
}

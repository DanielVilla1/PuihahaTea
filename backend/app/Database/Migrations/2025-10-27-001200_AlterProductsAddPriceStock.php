<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterProductsAddPriceStock extends Migration
{
    public function up()
    {
        $fields = [
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => '0.00',
                'null' => false,
                'after' => 'img',
            ],
            'stock' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => false,
                'after' => 'price',
            ],
        ];
        $this->forge->addColumn('products', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('products', ['price', 'stock']);
    }
}

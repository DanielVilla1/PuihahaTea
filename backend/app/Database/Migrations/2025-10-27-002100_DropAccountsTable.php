<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropAccountsTable extends Migration
{
    public function up()
    {
        // Drop legacy 'accounts' table if it still exists to avoid confusion.
        if ($this->db->tableExists('accounts')) {
            $this->forge->dropTable('accounts', true);
        }
    }

    public function down()
    {
        // Intentionally left as a no-op to avoid reintroducing deprecated schema.
        // If rollback is required in the future, re-create the table explicitly
        // with the desired legacy schema.
    }
}

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $email = 'puihahateaadmin@gmail.com';
        $name  = 'PuihahaTea Admin';
        $hash  = password_hash('puihahatea', PASSWORD_BCRYPT);

        $db = \Config\Database::connect();
        $builder = $db->table('users');

        // Demote any existing admins (other than the designated one) to manager
        $builder
            ->where('employee_type', 'admin')
            ->where('email !=', $email)
            ->update([
                'employee_type' => 'manager',
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);

        $existing = $builder->where('email', $email)->get()->getRowArray();
        if ($existing) {
            // Ensure the account is admin and active; update password to known value
            $builder->where('id', $existing['id'])->update([
                'name'          => $name,
                'cellphone'     => $existing['cellphone'] ?? '09170000000',
                'password_hash' => $hash,
                'employee_type' => 'admin',
                'status'        => 'active',
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
        } else {
            $builder->insert([
                'name'          => $name,
                'email'         => $email,
                'cellphone'     => '09170000000',
                'password_hash' => $hash,
                'employee_type' => 'admin',
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
        }
    }
}

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmployeesSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');

        $password = password_hash('puihaha123', PASSWORD_BCRYPT);

        // Define 22 staff and 2 managers
        $rows = [];
        for ($i = 1; $i <= 22; $i++) {
            $rows[] = [
                'name'          => sprintf('Staff %02d', $i),
                'email'         => sprintf('staff%02d@puihahatest.local', $i),
                'password_hash' => $password,
                'employee_type' => 'staff',
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ];
        }
        for ($i = 1; $i <= 2; $i++) {
            $rows[] = [
                'name'          => sprintf('Manager %02d', $i),
                'email'         => sprintf('manager%02d@puihahatest.local', $i),
                'password_hash' => $password,
                'employee_type' => 'manager',
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ];
        }

        // Insert if not exists by email; otherwise update core fields (except type if it is admin)
        foreach ($rows as $row) {
            $existing = $builder->where('email', $row['email'])->get()->getRowArray();
            if ($existing) {
                // Skip touching admin accounts and preserve current role if admin
                if (($existing['employee_type'] ?? '') === 'admin') {
                    continue;
                }
                $builder->where('id', $existing['id'])->update([
                    'name'          => $row['name'],
                    'password_hash' => $row['password_hash'],
                    'employee_type' => $row['employee_type'],
                    'status'        => $row['status'],
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);
            } else {
                $builder->insert($row);
            }
        }
    }
}

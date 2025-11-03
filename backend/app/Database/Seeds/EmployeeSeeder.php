<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');

        $now = date('Y-m-d H:i:s');
        $password = password_hash('password123', PASSWORD_BCRYPT);

        // Deterministic name pools to generate realistic names
        $firstNames = [
            'John',
            'Jane',
            'Michael',
            'Sarah',
            'David',
            'Emily',
            'Robert',
            'Olivia',
            'Daniel',
            'Sophia',
            'James',
            'Ava',
            'William',
            'Mia',
            'Joseph',
            'Isabella',
            'Thomas',
            'Amelia',
            'Charles',
            'Harper',
            'Henry',
            'Ethan',
            'Grace',
            'Noah',
            'Liam',
            'Lucas',
            'Emma',
            'Aria',
            'Benjamin',
            'Chloe'
        ];
        $lastNames = [
            'Doe',
            'Smith',
            'Johnson',
            'Williams',
            'Brown',
            'Jones',
            'Garcia',
            'Miller',
            'Davis',
            'Rodriguez',
            'Martinez',
            'Hernandez',
            'Lopez',
            'Gonzalez',
            'Wilson',
            'Anderson',
            'Thomas',
            'Taylor',
            'Moore',
            'Jackson',
            'Martin',
            'Lee',
            'Perez',
            'Thompson',
            'White',
            'Harris',
            'Sanchez',
            'Clark',
            'Ramirez',
            'Lewis'
        ];

        $rows = [];
        for ($i = 1; $i <= 120; $i++) {
            $num = str_pad((string) $i, 3, '0', STR_PAD_LEFT);
            $email = "staff{$num}@puihahatea.local";
            // Generate a simple PH-style cellphone number (11 digits)
            $cell  = '0917' . str_pad((string) $i, 7, '0', STR_PAD_LEFT);
            // Deterministic random-looking name per index
            $fn = $firstNames[($i - 1) % count($firstNames)];
            $ln = $lastNames[(($i - 1) * 3) % count($lastNames)];
            $rows[] = [
                'name'          => "$fn $ln",
                'email'         => $email,
                'cellphone'     => $cell,
                'password_hash' => $password,
                'employee_type' => 'staff',
                'status'        => 'active',
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        // Prevent duplicates: filter out emails that already exist
        $emails = array_column($rows, 'email');
        if (! empty($emails)) {
            $existing = $builder->select('email')->whereIn('email', $emails)->get()->getResultArray();
            $existingEmails = array_map(static fn($r) => $r['email'], $existing);
            $rows = array_values(array_filter($rows, static fn($r) => ! in_array($r['email'], $existingEmails, true)));
        }

        if (! empty($rows)) {
            // Insert in batches for efficiency
            $builder->insertBatch($rows, 50);
        }

        // Backfill cellphone for existing seeded staff without cellphone
        $existingStaff = $builder->select('id,email,cellphone')
            ->like('email', 'staff', 'after')
            ->get()
            ->getResultArray();
        foreach ($existingStaff as $row) {
            if (!empty($row['cellphone'])) continue;
            // Extract number from email e.g., staff042@...
            if (preg_match('/staff(\d{3})@/i', $row['email'], $m)) {
                $n = (int) $m[1];
                $cell = '0917' . str_pad((string) $n, 7, '0', STR_PAD_LEFT);
                $builder->where('id', (int) $row['id'])->update([
                    'cellphone' => $cell,
                    'updated_at' => $now,
                ]);
            }
        }

        // Backfill names for existing seeded staff still using the placeholder pattern "Staff NNN"
        $existingNames = $builder->select('id,email,name')
            ->like('email', 'staff', 'after')
            ->get()
            ->getResultArray();
        foreach ($existingNames as $row) {
            if (!preg_match('/^Staff\s\d{3}$/', $row['name'] ?? '')) {
                continue; // keep edited names intact
            }
            if (preg_match('/staff(\d{3})@/i', $row['email'], $m)) {
                $idx = (int) $m[1];
                $fn = $firstNames[($idx - 1) % count($firstNames)];
                $ln = $lastNames[(($idx - 1) * 3) % count($lastNames)];
                $builder->where('id', (int) $row['id'])->update([
                    'name' => "$fn $ln",
                    'updated_at' => $now,
                ]);
            }
        }
    }
}

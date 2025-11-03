<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\CustomerModel;

class CustomersRandomSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $model = new CustomerModel();

        // Determine a baseline older-than-first timestamp
        $minCreated = null;
        try {
            $row = $db->query('SELECT MIN(created_at) AS minc FROM customers')->getRowArray();
            if ($row && ! empty($row['minc'])) {
                $minCreated = strtotime($row['minc']);
            }
        } catch (\Throwable $e) {
            $minCreated = null;
        }
        $nowTs = time();
        if (! $minCreated) {
            // If table empty or created_at null, set baseline to ~120 days ago
            $minCreated = $nowTs - (120 * 24 * 3600);
        }

        $firstNames = ['Juan', 'Maria', 'Jose', 'Ana', 'Daniel', 'Luz', 'Carlos', 'Rosa', 'Miguel', 'Elena', 'Marco', 'Bianca', 'Paolo', 'Ivy', 'Noah', 'Liam', 'Emma', 'Ava'];
        $lastNames  = ['Dela Cruz', 'Santos', 'Reyes', 'Gomez', 'Garcia', 'Ramos', 'Torres', 'Flores', 'Mendoza', 'Navarro', 'Villanueva', 'Castillo', 'Rivera', 'Fernandez'];
        $barangays  = ['San Isidro', 'San Roque', 'San Jose', 'Sto. Niño', 'Poblacion', 'Mabini', 'San Antonio'];
        $cities     = ['Quezon City', 'Manila', 'Makati', 'Pasig', 'Taguig', 'Cebu City', 'Davao City'];
        $provinces  = ['Metro Manila', 'Cebu', 'Davao del Sur', 'Laguna', 'Rizal'];

        $statuses   = ['regular', 'vip', 'guest'];

        $rows = [];
        for ($i = 0; $i < 120; $i++) {
            $fname = $firstNames[array_rand($firstNames)];
            $lname = $lastNames[array_rand($lastNames)];
            $name  = $fname . ' ' . $lname;
            $local = strtolower(str_replace(' ', '', $fname . '.' . $lname)) . '.' . dechex(random_int(0, 0xFFFF));
            $email = $local . '@example.test';
            $status = $statuses[array_rand($statuses)];

            // Create older timestamps to appear BELOW originals when ordered by created_at DESC
            $offsetDays = random_int(60, 180); // 2-6 months before baseline
            $createdTs  = $minCreated - ($offsetDays * 24 * 3600) - random_int(0, 86400);
            $createdAt  = date('Y-m-d H:i:s', $createdTs);
            $verifiedAt = date('Y-m-d H:i:s', $createdTs + random_int(3600, 72 * 3600));

            $account = 'CUST-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
            $cell    = '09' . str_pad((string) random_int(100000000, 999999999), 9, '0', STR_PAD_LEFT);
            $addr    = 'Blk ' . random_int(1, 99) . ', Lot ' . random_int(1, 99)
                . ' ' . $barangays[array_rand($barangays)] . ', '
                . $cities[array_rand($cities)] . ', ' . $provinces[array_rand($provinces)];

            $rows[] = [
                'account_number'    => $account,
                'name'              => $name,
                'address'           => $addr,
                'email'             => $email,
                'cellphone'         => $cell,
                'status'            => $status,
                'password_hash'     => null,
                'verification_token' => null,
                'token_sent_at'     => null,
                'verified_at'       => $verifiedAt,
                'created_at'        => $createdAt,
                'updated_at'        => $createdAt,
            ];
        }

        // Insert in batches to improve performance
        $chunk = 40;
        foreach (array_chunk($rows, $chunk) as $batch) {
            $model->insertBatch($batch);
        }
    }
}

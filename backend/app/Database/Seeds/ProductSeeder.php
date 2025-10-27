<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Mango Breeze Oolong',
                'desc'  => 'Juicy mango with silky oolong and lemongrass.',
                'img'   => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQjLCaJ2aomuJX3xSt57LrOMSHPl0ykM-7jUA&s',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Pineapple Mint Sencha',
                'desc'  => 'Bright sencha with pineapple and garden mint.',
                'img'   => 'https://images.unsplash.com/photo-1523906630133-f6934a1ab1ef?q=80&w=1200&auto=format&fit=crop',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Passionfruit Hibiscus Cooler',
                'desc'  => 'Tart hibiscus balanced by passionfruit sweetness.',
                'img'   => 'https://images.unsplash.com/photo-1546177461-1a4a1e1b37b8?q=80&w=1200&auto=format&fit=crop',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('products')->insertBatch($data);
    }
}

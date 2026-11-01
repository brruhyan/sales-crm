<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;


    public function run(): void
    {
        $userId = User::query()->value('id');

        if ($userId === null) {
            throw new \RuntimeException('A user is required before products can be seeded.');
        }

        $services = [
            [
                'product_name' => 'Data Fusion 360',
                'description' => 'Advanced Data Integration and Analytics Platform',
                'link' => 'https://maralabs.ph/marabiz/datafusion-360/',
                'sellable' => true,
            ],

            [
                'product_name' => 'AksyonSentral',
                'description' => 'Incident Managment and Data Aggregator Platform',
                'link' => 'https://maralabs.ph/marabiz/aksyon-sentral/',
                'sellable' => true,
            ],

            [
                'product_name' => 'AksyonMap',
                'description' => 'Geographic Information System (GIS) and Mapping Product',
                'link' => 'https://maralabs.ph/marabiz/aksyon-map/',
                'sellable' => true,
            ]
        ];

        foreach ($services as $service) {
            DB::table('products')->updateOrInsert(
                [
                    'product_name' => $service['product_name'],
                    'user_id' => $userId,
                ],
                [
                    ...$service,
                    'user_id' => $userId,
                    'updated_at' => now(),
                    'created_at' => now(),
                ],
            );
        }
    }
}

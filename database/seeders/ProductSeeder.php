<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;


    public function run(): void
    {
        DB::table('products')
            ->whereIn('product_name', ['Data Fusion 360', 'AksyonSentral', 'AksyonMap'])
            ->delete();

        $services = [
            [
                'product_name' => 'Placeholder Product One',
                'description' => 'Placeholder product for demonstration purposes.',
                'link' => null,
                'sellable' => true,
            ],

            [
                'product_name' => 'Placeholder Product Two',
                'description' => 'Placeholder product for demonstration purposes.',
                'link' => null,
                'sellable' => true,
            ],

            [
                'product_name' => 'Placeholder Product Three',
                'description' => 'Placeholder product for demonstration purposes.',
                'link' => null,
                'sellable' => true,
            ]
        ];

        foreach ($services as $service) {
            DB::table('products')->updateOrInsert(
                [
                    'product_name' => $service['product_name'],
                    'user_id' => null,
                ],
                [
                    ...$service,
                    'user_id' => null,
                    'updated_at' => now(),
                    'created_at' => now(),
                ],
            );
        }
    }
}

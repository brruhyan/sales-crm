<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;


    public function run(): void
    {
        $services = [
            [
                'product_name' => 'Data Fusion 360',
                'description' => 'Advanced Data Integration and Analytics Platform',
                'category' => 'MaraBiz',
                'link' => 'https://maralabs.ph/marabiz/datafusion-360/',
                'sellable' => true,
            ],

            [
                'product_name' => 'AksyonSentral',
                'description' => 'Incident Managment and Data Aggregator Platform',
                'category' => 'MaraBiz',
                'link' => 'https://maralabs.ph/marabiz/aksyon-sentral/',
                'sellable' => true,
            ],

            [
                'product_name' => 'AksyonMap',
                'description' => 'Geographic Information System (GIS) and Mapping Product',
                'category' => 'MaraBiz',
                'link' => 'https://maralabs.ph/marabiz/aksyon-map/',
                'sellable' => true,
            ]
        ];

        foreach ($services as $service) {
            Product::create($service);
        }
    }
}

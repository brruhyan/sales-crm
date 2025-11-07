<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the products table with company services.
     */
    public function run(): void
    {
        $services = [
            [
                'product_name' => 'Data Fusion 360',
                'description' => 'Advanced Data Integration and Analytics Platform',
                'features' => "Real-time data integration\nAdvanced analytics and reporting",
                'benefits' => "Improved decision-making\nIncreased operational efficiency",
                'use_cases' => "Business intelligence\nMarketing analytics",
                'link' => 'https://maralabs.ph/marabiz/datafusion-360/',
                'price' => 5000.00,
                'sellable' => true,
            ],

        ];

        foreach ($services as $service) {
            Product::create($service);
        }
    }
}

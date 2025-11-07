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
                'features' => "Real-time data integration\nAdvanced analytics and reporting\nUser-friendly dashboard\nAPI access\nCustomizable workflows",
                'benefits' => "Improved decision-making\nIncreased operational efficiency\nEnhanced data visibility\nScalable architecture\nReduced time to insights",
                'use_cases' => "Business intelligence\nMarketing analytics\nFinancial reporting\nCustomer insights\nOperational analytics",
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

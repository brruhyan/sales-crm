<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database. Test
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            PartnerSeeder::class,
            ProductListSeeder::class,
            ProductSeeder::class,
            ContactSeeder::class,
            LeadSeeder::class,
            DealSeeder::class,
        ]);
    }
}

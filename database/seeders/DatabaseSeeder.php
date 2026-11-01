<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '12341234',
            'approved' => true,
        ]);

        $this->call([
            PartnerSeeder::class,
            ProductListSeeder::class,
            ProductSeeder::class,
            AdminUserSeeder::class,
            ContactSeeder::class,
            LeadSeeder::class,
            DealSeeder::class,
        ]);
    }
}

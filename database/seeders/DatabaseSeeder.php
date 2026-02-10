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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '12341234',
            'approved' => true,
        ]);

        // Call other seeders
        $this->call([
            PartnerSeeder::class,
            ProductListSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}

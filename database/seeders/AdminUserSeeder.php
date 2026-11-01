<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'test@test.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('test123'),
                'is_admin' => true,
                'approved' => true,
                'tin_number' => '123-456-789',
                'email_verified_at' => now(),
                'documents' => [], // Let the model cast handle the JSON encoding
            ]
        );
        
        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: test@test.com');
        $this->command->info('Password: test123');
    }
}

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
        User::firstOrCreate(
            ['email' => 'bryan@maralabs.ph'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Stickpage1!'),
                'is_admin' => true,
                'approved' => true,
                'email_verified_at' => now(),
            ]
        );
        
        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@maralabs.com');
        $this->command->info('Password: Admin@123');
    }
}

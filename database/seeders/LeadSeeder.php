<?php

namespace Database\Seeders;

use App\Models\Leads;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the test user
        $user = \App\Models\User::where('email', 'test@example.com')->first();

        if ($user) {
            // Get contacts for this user
            $contacts = Contact::where('user_id', $user->id)->get();

            // Create 15 leads
            for ($i = 0; $i < 15; $i++) {
                Leads::factory()->create([
                    'user_id' => $user->id,
                    'contact_id' => $contacts->isNotEmpty() ? $contacts->random()->id : null,
                ]);
            }
        }
    }
}

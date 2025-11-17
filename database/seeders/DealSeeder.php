<?php

namespace Database\Seeders;

use App\Models\Deal;
use App\Models\Leads;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class DealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the test user
        $user = \App\Models\User::where('email', 'test@example.com')->first();

        if ($user) {
            // Get leads and contacts for this user
            $leads = Leads::where('user_id', $user->id)->get();
            $contacts = Contact::where('user_id', $user->id)->get();

            // Create 12 deals
            for ($i = 0; $i < 12; $i++) {
                Deal::factory()->create([
                    'user_id' => $user->id,
                    'lead_id' => $leads->isNotEmpty() ? $leads->random()->id : null,
                    'contact_id' => $contacts->isNotEmpty() ? $contacts->random()->id : null,
                ]);
            }
        }
    }
}

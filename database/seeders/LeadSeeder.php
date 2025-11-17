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
        $user = \App\Models\User::where('email', 'test@example.com')->first();

        if ($user) {
            $contacts = Contact::where('user_id', $user->id)->get();

            for ($i = 0; $i < 15; $i++) {
                Leads::factory()->create([
                    'user_id' => $user->id,
                    'contact_id' => $contacts->isNotEmpty() ? $contacts->random()->id : null,
                ]);
            }
        }
    }
}

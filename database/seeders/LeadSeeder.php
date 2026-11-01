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
        $contacts = Contact::whereNull('user_id')->get();

        for ($i = 0; $i < 15; $i++) {
            Leads::factory()->create([
                'user_id' => null,
                'contact_id' => $contacts->isNotEmpty() ? $contacts->random()->id : null,
            ]);
        }
    }
}

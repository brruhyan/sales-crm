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
        $leads = Leads::whereNull('user_id')->get();
        $contacts = Contact::whereNull('user_id')->get();

        for ($i = 0; $i < 12; $i++) {
            Deal::factory()->create([
                'user_id' => null,
                'lead_id' => $leads->isNotEmpty() ? $leads->random()->id : null,
                'contact_id' => $contacts->isNotEmpty() ? $contacts->random()->id : null,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            'Department of National Defense',
            'Department of Environment and Natural Resources',
            'Department of Energy',
            'Philippine Ports Authority',
            'National Commission on Indigenous Peoples',
            'Department of Health',
            'Tourism Promotions Board',
            'Construction Industry Authority of the Philippines',
            'City of Palawan',
            'City of Alabat',
            'City of Pasig',
            'Other Government',
            'Landbank Resources and Development Corp (LBRDC)',
            'Pampanga State Agricultural University',
            'CARD Bank Inc.',
            'ASLA Savings and Loans Association',
            'Earth Island Institute',
            'Digital Halo DC Phils Inc',
            'iTelecast PH',
            'Others',
        ];

        foreach ($partners as $partner) {
            Partner::firstOrCreate(['name' => $partner]);
        }
    }
}

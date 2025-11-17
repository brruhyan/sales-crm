<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    public const OPTIONS = [
        'Department of National Defense' => 'Department of National Defense',
        'Department of Environment and Natural Resources' => 'Department of Environment and Natural Resources',
        'Department of Energy' => 'Department of Energy',
        'Philippine Ports Authority' => 'Philippine Ports Authority',
        'National Commission on Indigenous Peoples' => 'National Commission on Indigenous Peoples',
        'Department of Health' => 'Department of Health',
        'Tourism Promotions Board' => 'Tourism Promotions Board',
        'Construction Industry Authority of the Philippines' => 'Construction Industry Authority of the Philippines',
        'City of Palawan' => 'City of Palawan',
        'City of Alabat' => 'City of Alabat',
        'City of Pasig' => 'City of Pasig',
        'Other Government' => 'Other Government',
        'Landbank Resources and Development Corp (LBRDC)' => 'Landbank Resources and Development Corp (LBRDC)',
        'Pampanga State Agricultural University' => 'Pampanga State Agricultural University',
        'CARD Bank Inc.' => 'CARD Bank Inc.',
        'ASLA Savings and Loans Association' => 'ASLA Savings and Loans Association',
        'Earth Island Institute' => 'Earth Island Institute',
        'Digital Halo DC Phils Inc' => 'Digital Halo DC Phils Inc',
        'iTelecast PH' => 'iTelecast PH',
        'Others' => 'Others',
    ];
}

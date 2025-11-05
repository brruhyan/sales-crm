<?php

namespace App\Filament\Client\Resources\Deals\Pages;

use App\Filament\Client\Resources\Deals\DealResource;
use App\Models\Leads;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateDeal extends CreateRecord
{
    protected static string $resource = DealResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        
        // If title is not set, get it from the associated lead
        if (empty($data['title']) && !empty($data['source'])) {
            $lead = Leads::find($data['source']);
            if ($lead) {
                $data['title'] = $lead->lead_title;
            }
        }
        
        return $data;
    }
}

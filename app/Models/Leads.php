<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leads extends Model
{   
    use SoftDeletes;

    protected $fillable = [
        'contact_id',
        'name',
        'email',
        'phone',
        'company',
        'source',
        'status',
    ];

    /**
     * Get the contact associated with this lead.
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}

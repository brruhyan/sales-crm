<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leads extends Model
{   
    use SoftDeletes;

    protected $fillable = [
        'lead_title',
        'user_id',
        'product',
        'category',
        'contact_id',
        'name',
        'email',
        'phone',
        'company',
        'source',
        'status',
        'documents',
        'qualified_documents',
    ];

    protected $casts = [
        'documents' => 'array',
        'qualified_documents' => 'array',
    ];

    /**
     * Get the user who owns this lead.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the contact associated with this lead.
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}

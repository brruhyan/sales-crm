<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Leads extends Model
{   
    use SoftDeletes, Notifiable, HasFactory;

    protected $fillable = [
        'lead_title',
        'lead_type',
        'user_id',
        'product',
        'contact_id',
        'name',
        'email',
        'phone',
        'company',
        'source',
        'status',
        'documents',
        'qualified_documents',
        'dispute_reason',
    ];

    protected $casts = [
        'documents' => 'array',
        'qualified_documents' => 'array',
        'product' => 'array',
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

    /**
     * Get the partner/company for this lead.
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'company', 'id');
    }
}

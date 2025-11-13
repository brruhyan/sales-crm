<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Leads;

class Deal extends Model
{
    protected $fillable = [
        'title',
        'description',
        'amount',
        'currency',
        'probability',
        'status',
        'source',
        'expected_close_date',
        'actual_close_date',
        'contact_id',
        'lead_id',
        'user_id',
        'documents',
        'won_documents',
        'dispute_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'probability' => 'integer',
        'expected_close_date' => 'date',
        'actual_close_date' => 'date',  
        'documents' => 'array',
        'won_documents' => 'array',
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Scope to get only closed deals.
     */
    public function scopeClosed($query)
    {
        return $query->whereIn('status', ['Closed Won', 'Closed Lost']);
    }

    /**
     * Scope to get only won deals.
     */
    public function scopeWon($query)
    {
        return $query->where('status', 'Closed Won');
    }

    /**
     * Scope to get only lost deals.
     */
    public function scopeLost($query)
    {
        return $query->where('status', 'Closed Lost');
    }

    /**
     * Scope to get active (not closed) deals.
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['Closed Won', 'Closed Lost']);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Leads::class, 'lead_id');
    }
}

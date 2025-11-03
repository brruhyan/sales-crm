<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{
    use SoftDeletes;

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
        'user_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'probability' => 'integer',
        'expected_close_date' => 'date',
        'actual_close_date' => 'date',
    ];

    /**
     * Get the contact associated with this deal.
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Get the user (sales rep) who owns this deal.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the projects associated with this deal.
     */
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
}

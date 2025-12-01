<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partner extends Model
{
    protected $fillable = ['name', 'user_id'];

    /**
     * Get the user who owns this partner.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all contacts associated with this partner.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'company', 'id');
    }

    /**
     * Get all partners as options for select fields
     */
    public static function getOptions(): array
    {
        return static::pluck('name', 'id')->toArray();
    }
}

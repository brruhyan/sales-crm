<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'position'
    ];

    /**
     * Get the deals associated with this contact.
     */
    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }
}

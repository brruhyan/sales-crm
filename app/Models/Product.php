<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_name',
        'image',
        'description',
        'features',
        'benefits',
        'use_cases',
        'link',
        'sellable',
        'user_id',
    ];

    protected $casts = [
        'sellable' => 'boolean',
    ];

    /**
     * Get the user who owns this product.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

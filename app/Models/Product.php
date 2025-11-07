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
        'company_name',
        'description',
        'features',
        'benefits',
        'use_cases',
        'link',
        'price',
        'sellable',
        'user_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
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

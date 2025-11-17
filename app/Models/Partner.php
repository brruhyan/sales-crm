<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = ['name'];

    /**
     * Get all partners as options for select fields
     */
    public static function getOptions(): array
    {
        return static::pluck('name', 'id')->toArray();
    }
}

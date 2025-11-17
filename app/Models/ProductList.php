<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductList extends Model
{   
    protected $fillable = [
        'name',
    ];

    public static function getOptions(): array
    {
        return static::pluck('name', 'id')->toArray();
    }

}



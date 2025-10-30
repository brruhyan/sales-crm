<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leads extends Model
{   
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'source',
        'status',
    ];
    
    use SoftDeletes;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'name',
        'category',
        'quantity',
        'condition',
        'location',
        'purchased_date',
    ];

    protected $casts = [
        'purchased_date' => 'date',
    ];
}

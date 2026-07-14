<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolInformation extends Model
{
    protected $table = 'school_information';

    protected $fillable = [
        'school_name',
        'logo',
        'address',
        'phone',
        'email',
    ];
}

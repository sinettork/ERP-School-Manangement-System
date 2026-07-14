<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LibraryBook extends Model
{
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'category',
        'quantity',
        'available_quantity',
        'shelf_location',
    ];

    public function borrowBooks(): HasMany
    {
        return $this->hasMany(BorrowBook::class, 'book_id');
    }
}

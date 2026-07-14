<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ParentGuardian extends Model
{
    protected $table = 'parents';

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'address',
        'occupation',
        'relation_type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_guardians', 'parent_id', 'student_id')
            ->withPivot('relationship')
            ->withTimestamps();
    }
}

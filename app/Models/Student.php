<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'student_code',
        'photo',
        'name_kh',
        'name_en',
        'gender',
        'dob',
        'address',
        'father_name',
        'mother_name',
        'phone',
        'class_id',
        'academic_year_id',
        'status',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function guardians(): BelongsToMany
    {
        return $this->belongsToMany(ParentGuardian::class, 'student_guardians', 'student_id', 'parent_id')
            ->withPivot('relationship')
            ->withTimestamps();
    }

    public function studentClasses(): HasMany
    {
        return $this->hasMany(StudentClass::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function reportCards(): HasMany
    {
        return $this->hasMany(ReportCard::class);
    }

    public function borrowBooks(): HasMany
    {
        return $this->hasMany(BorrowBook::class);
    }

    public function studentCards(): HasMany
    {
        return $this->hasMany(StudentCard::class);
    }
}

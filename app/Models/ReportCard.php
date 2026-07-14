<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportCard extends Model
{
    protected $fillable = [
        'student_id',
        'class_id',
        'semester_id',
        'academic_year_id',
        'average_score',
        'rank',
        'total_absent',
        'pdf_path',
        'generated_at',
    ];

    protected $casts = [
        'average_score' => 'decimal:2',
        'generated_at'  => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}

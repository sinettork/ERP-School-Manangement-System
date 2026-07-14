<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'exam_id',
        'class_id',
        'semester_id',
        'homework_score',
        'classwork_score',
        'exam_score',
        'total_score',
        'grade',
    ];

    protected $casts = [
        'homework_score'  => 'decimal:2',
        'classwork_score' => 'decimal:2',
        'exam_score'      => 'decimal:2',
        'total_score'     => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }
}

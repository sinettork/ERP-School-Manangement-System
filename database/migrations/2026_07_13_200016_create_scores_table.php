<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('exam_id')->constrained('exams')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('semester_id')->nullable()->constrained('semesters')->nullOnDelete();
            $table->decimal('homework_score', 5, 2)->default(0);
            $table->decimal('classwork_score', 5, 2)->default(0);
            $table->decimal('exam_score', 5, 2)->default(0);
            $table->decimal('total_score', 5, 2)->default(0);
            $table->string('grade')->nullable(); // A, B, C, D, F
            $table->timestamps();

            $table->unique(['student_id', 'subject_id', 'exam_id'], 'score_student_subject_exam_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};

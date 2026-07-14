<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\SchoolClass;
use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function index(Request $request)
    {
        $exams    = Exam::with('academicYear')->latest()->get();
        $classes  = SchoolClass::orderBy('name')->get();
        $subjects = Subject::orderBy('name_kh')->get();
        $examId   = $request->input('exam_id');
        $classId  = $request->input('class_id');
        $scores   = collect();
        $students = collect();

        if ($examId && $classId) {
            $students = Student::where('class_id', $classId)->where('status', 'active')->orderBy('name_kh')->get();
            $existing = Score::where('exam_id', $examId)->where('class_id', $classId)->get()->keyBy(fn($s) => $s->student_id . '_' . $s->subject_id);
            $scores   = $existing;
        }

        return view('scores.index', compact('exams', 'classes', 'subjects', 'examId', 'classId', 'students', 'scores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id'    => 'required|exists:exams,id',
            'class_id'   => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'scores'     => 'required|array',
        ]);

        $exam = Exam::find($request->exam_id);

        foreach ($request->scores as $studentId => $row) {
            $hw   = (float) ($row['homework_score']  ?? 0);
            $cw   = (float) ($row['classwork_score'] ?? 0);
            $ex   = (float) ($row['exam_score']      ?? 0);
            $total = $hw + $cw + $ex;

            Score::updateOrCreate(
                ['student_id' => $studentId, 'subject_id' => $request->subject_id, 'exam_id' => $request->exam_id],
                [
                    'class_id'        => $request->class_id,
                    'semester_id'     => $exam->semester_id,
                    'homework_score'  => $hw,
                    'classwork_score' => $cw,
                    'exam_score'      => $ex,
                    'total_score'     => $total,
                    'grade'           => $this->calcGrade($total),
                ]
            );
        }

        return redirect()->back()->with('success', 'បានរក្សាទុកពិន្ទុដោយជោគជ័យ!');
    }

    private function calcGrade(float $total): string
    {
        return match (true) {
            $total >= 90 => 'A',
            $total >= 80 => 'B',
            $total >= 70 => 'C',
            $total >= 60 => 'D',
            default      => 'F',
        };
    }
}

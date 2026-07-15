<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\SchoolClass;
use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $data = $request->validate([
            'exam_id'    => 'required|exists:exams,id',
            'class_id'   => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'scores'     => 'required|array',
            'scores.*.homework_score' => 'nullable|numeric|min:0|max:10',
            'scores.*.classwork_score' => 'nullable|numeric|min:0|max:20',
            'scores.*.exam_score' => 'nullable|numeric|min:0|max:70',
        ]);

        $exam = Exam::findOrFail($data['exam_id']);
        $class = SchoolClass::findOrFail($data['class_id']);

        if ($class->academic_year_id !== $exam->academic_year_id) {
            return back()->withErrors(['class_id' => 'ថ្នាក់រៀន និងការប្រឡងត្រូវតែស្ថិតក្នុងឆ្នាំសិក្សាតែមួយ។'])->withInput();
        }

        $studentIds = array_keys($data['scores']);
        $validStudentIds = Student::where('class_id', $class->id)
            ->where('status', 'active')
            ->whereIn('id', $studentIds)
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->all();

        if (array_diff(array_map('strval', $studentIds), $validStudentIds)) {
            return back()->withErrors(['scores' => 'ពិន្ទុត្រូវតែបញ្ចូលសម្រាប់សិស្សសកម្មក្នុងថ្នាក់ដែលបានជ្រើស។'])->withInput();
        }

        DB::transaction(function () use ($data, $exam) {
            foreach ($data['scores'] as $studentId => $row) {
                $hw = (float) ($row['homework_score'] ?? 0);
                $cw = (float) ($row['classwork_score'] ?? 0);
                $ex = (float) ($row['exam_score'] ?? 0);
                $total = $hw + $cw + $ex;

                Score::updateOrCreate(
                    ['student_id' => $studentId, 'subject_id' => $data['subject_id'], 'exam_id' => $data['exam_id']],
                    [
                        'class_id' => $data['class_id'],
                        'semester_id' => $exam->semester_id,
                        'homework_score' => $hw,
                        'classwork_score' => $cw,
                        'exam_score' => $ex,
                        'total_score' => $total,
                        'grade' => $this->calcGrade($total),
                    ]
                );
            }
        });

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

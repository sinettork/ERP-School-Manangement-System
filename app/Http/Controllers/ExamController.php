<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Exam;
use App\Models\Semester;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $query = Exam::with(['academicYear', 'semester'])->latest();

        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        $exams         = $query->paginate(15)->withQueryString();
        $academicYears = AcademicYear::orderByDesc('start_date')->get();

        return view('exams.index', compact('exams', 'academicYears'));
    }

    public function create()
    {
        $academicYears = AcademicYear::orderByDesc('start_date')->get();
        $semesters     = Semester::with('academicYear')->get();
        return view('exams.create', compact('academicYears', 'semesters'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:100',
            'exam_type'        => 'required|in:monthly,midterm,final',
            'academic_year_id' => 'required|exists:academic_years,id',
            'semester_id'      => 'nullable|exists:semesters,id',
            'start_date'       => 'nullable|date',
            'end_date'         => 'nullable|date|after_or_equal:start_date',
        ]);

        Exam::create($data);
        return redirect()->route('exams.index')
            ->with('success', 'បានបន្ថែមការប្រឡងថ្មីដោយជោគជ័យ!');
    }

    public function edit(Exam $exam)
    {
        $academicYears = AcademicYear::orderByDesc('start_date')->get();
        $semesters     = Semester::with('academicYear')->get();
        return view('exams.edit', compact('exam', 'academicYears', 'semesters'));
    }

    public function update(Request $request, Exam $exam)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:100',
            'exam_type'        => 'required|in:monthly,midterm,final',
            'academic_year_id' => 'required|exists:academic_years,id',
            'semester_id'      => 'nullable|exists:semesters,id',
            'start_date'       => 'nullable|date',
            'end_date'         => 'nullable|date|after_or_equal:start_date',
        ]);

        $exam->update($data);
        return redirect()->route('exams.index')
            ->with('success', 'បានកែប្រែការប្រឡងដោយជោគជ័យ!');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('exams.index')
            ->with('success', 'បានលុបការប្រឡងដោយជោគជ័យ!');
    }
}

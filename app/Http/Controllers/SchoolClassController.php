<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index(Request $request)
    {
        $query = SchoolClass::with(['academicYear', 'homeroomTeacher', 'students'])
            ->latest();

        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        $classes       = $query->paginate(15)->withQueryString();
        $academicYears = AcademicYear::orderByDesc('start_date')->get();

        return view('classes.index', compact('classes', 'academicYears'));
    }

    public function create()
    {
        $teachers      = Teacher::orderBy('name')->get();
        $academicYears = AcademicYear::orderByDesc('start_date')->get();
        return view('classes.create', compact('teachers', 'academicYears'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                => 'required|string|max:50',
            'grade_level'         => 'required|string|max:20',
            'room'                => 'nullable|string|max:30',
            'shift'               => 'required|in:morning,afternoon',
            'homeroom_teacher_id' => 'nullable|exists:teachers,id',
            'max_students'        => 'required|integer|min:1|max:100',
            'academic_year_id'    => 'required|exists:academic_years,id',
        ]);

        SchoolClass::create($data);

        return redirect()->route('classes.index')
            ->with('success', 'បានបន្ថែមថ្នាក់រៀនថ្មីដោយជោគជ័យ!');
    }

    public function show(SchoolClass $class)
    {
        $class->load(['students', 'homeroomTeacher', 'classSchedules.subject', 'classSchedules.teacher']);
        return view('classes.show', compact('class'));
    }

    public function edit(SchoolClass $class)
    {
        $teachers      = Teacher::orderBy('name')->get();
        $academicYears = AcademicYear::orderByDesc('start_date')->get();
        return view('classes.edit', compact('class', 'teachers', 'academicYears'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $data = $request->validate([
            'name'                => 'required|string|max:50',
            'grade_level'         => 'required|string|max:20',
            'room'                => 'nullable|string|max:30',
            'shift'               => 'required|in:morning,afternoon',
            'homeroom_teacher_id' => 'nullable|exists:teachers,id',
            'max_students'        => 'required|integer|min:1|max:100',
            'academic_year_id'    => 'required|exists:academic_years,id',
        ]);

        $class->update($data);

        return redirect()->route('classes.index')
            ->with('success', 'បានកែប្រែថ្នាក់រៀនដោយជោគជ័យ!');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return redirect()->route('classes.index')
            ->with('success', 'បានលុបថ្នាក់រៀនដោយជោគជ័យ!');
    }
}

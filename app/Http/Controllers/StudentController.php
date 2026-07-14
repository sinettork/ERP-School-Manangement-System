<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['class', 'academicYear'])
            ->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name_kh', 'like', "%$s%")
                ->orWhere('name_en', 'like', "%$s%")
                ->orWhere('student_code', 'like', "%$s%"));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $students = $query->paginate(15)->withQueryString();
        $classes  = SchoolClass::orderBy('name')->get();

        return view('students.index', compact('students', 'classes'));
    }

    public function create()
    {
        $classes       = SchoolClass::orderBy('name')->get();
        $academicYears = AcademicYear::orderByDesc('start_date')->get();
        return view('students.create', compact('classes', 'academicYears'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_code'     => 'required|string|unique:students,student_code',
            'name_kh'          => 'required|string|max:100',
            'name_en'          => 'nullable|string|max:100',
            'gender'           => 'required|in:male,female,other',
            'dob'              => 'nullable|date',
            'address'          => 'nullable|string|max:255',
            'father_name'      => 'nullable|string|max:100',
            'mother_name'      => 'nullable|string|max:100',
            'phone'            => 'nullable|string|max:20',
            'class_id'         => 'nullable|exists:classes,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'status'           => 'required|in:active,inactive,graduated,dropped',
            'photo'            => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students/photos', 'public');
        }

        Student::create($data);

        return redirect()->route('students.index')
            ->with('success', 'បានបន្ថែមសិស្សថ្មីដោយជោគជ័យ!');
    }

    public function show(Student $student)
    {
        $student->load(['class', 'academicYear', 'guardians', 'attendances' => fn($q) => $q->latest()->limit(10), 'payments' => fn($q) => $q->latest()->limit(5)]);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $classes       = SchoolClass::orderBy('name')->get();
        $academicYears = AcademicYear::orderByDesc('start_date')->get();
        return view('students.edit', compact('student', 'classes', 'academicYears'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'student_code'     => 'required|string|unique:students,student_code,' . $student->id,
            'name_kh'          => 'required|string|max:100',
            'name_en'          => 'nullable|string|max:100',
            'gender'           => 'required|in:male,female,other',
            'dob'              => 'nullable|date',
            'address'          => 'nullable|string|max:255',
            'father_name'      => 'nullable|string|max:100',
            'mother_name'      => 'nullable|string|max:100',
            'phone'            => 'nullable|string|max:20',
            'class_id'         => 'nullable|exists:classes,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'status'           => 'required|in:active,inactive,graduated,dropped',
            'photo'            => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students/photos', 'public');
        }

        $student->update($data);

        return redirect()->route('students.index')
            ->with('success', 'បានកែប្រែព័ត៌មានសិស្សដោយជោគជ័យ!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')
            ->with('success', 'បានលុបសិស្សដោយជោគជ័យ!');
    }
}

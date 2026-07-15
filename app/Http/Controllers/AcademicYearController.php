<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcademicYearController extends Controller
{
    public function index()
    {
        $academicYears = AcademicYear::withCount(['classes', 'students', 'exams'])
            ->with('semesters')
            ->orderByDesc('start_date')
            ->get();

        return view('academic-years.index', compact('academicYears'));
    }

    public function create()
    {
        return view('academic-years.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:20',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'is_active'  => 'boolean',
        ]);

        DB::transaction(function () use ($request, $data) {
            if ($request->boolean('is_active')) {
                AcademicYear::where('is_active', true)->update(['is_active' => false]);
            }

            $year = AcademicYear::create($data);
            $semesterOneEnd = now()->parse($data['start_date'])->addMonths(4)->toDateString();

            Semester::create(['academic_year_id' => $year->id, 'name' => 'ឆមាសទី១', 'start_date' => $data['start_date'], 'end_date' => $semesterOneEnd]);
            Semester::create(['academic_year_id' => $year->id, 'name' => 'ឆមាសទី២', 'start_date' => now()->parse($semesterOneEnd)->addDay()->toDateString(), 'end_date' => $data['end_date']]);
        });

        return redirect()->route('academic-years.index')
            ->with('success', 'បានបន្ថែមឆ្នាំសិក្សាថ្មីដោយជោគជ័យ!');
    }

    public function edit(AcademicYear $academicYear)
    {
        return view('academic-years.edit', compact('academicYear'));
    }

    public function update(Request $request, AcademicYear $academicYear)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:20',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'is_active'  => 'boolean',
        ]);

        DB::transaction(function () use ($request, $academicYear, $data) {
            if ($request->boolean('is_active')) {
                AcademicYear::where('is_active', true)->where('id', '!=', $academicYear->id)->update(['is_active' => false]);
            }

            $academicYear->update($data);
        });

        return redirect()->route('academic-years.index')
            ->with('success', 'បានកែប្រែឆ្នាំសិក្សាដោយជោគជ័យ!');
    }

    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->delete();
        return redirect()->route('academic-years.index')
            ->with('success', 'បានលុបឆ្នាំសិក្សាដោយជោគជ័យ!');
    }
}

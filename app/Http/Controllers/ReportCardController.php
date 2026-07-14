<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ReportCard;
use App\Models\SchoolClass;
use App\Models\Semester;
use Illuminate\Http\Request;

class ReportCardController extends Controller
{
    public function index(Request $request)
    {
        $query = ReportCard::with(['student', 'class', 'semester', 'academicYear'])->latest();

        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        $reportCards   = $query->paginate(20)->withQueryString();
        $academicYears = AcademicYear::orderByDesc('start_date')->get();
        $classes       = SchoolClass::orderBy('name')->get();
        $semesters     = Semester::with('academicYear')->get();

        return view('report-cards.index', compact('reportCards', 'academicYears', 'classes', 'semesters'));
    }

    public function show(ReportCard $reportCard)
    {
        $reportCard->load(['student', 'class', 'semester', 'academicYear',
            'student.scores' => fn($q) => $q->where('semester_id', $reportCard->semester_id)
                ->with('subject'),
        ]);

        // Pass scores on the reportCard for view convenience
        $reportCard->setRelation('scores',
            $reportCard->student->scores->where('semester_id', $reportCard->semester_id)
        );

        return view('report-cards.show', compact('reportCard'));
    }

    public function destroy(ReportCard $reportCard)
    {
        $reportCard->delete();
        return redirect()->route('report-cards.index')
            ->with('success', 'បានលុបសៀវភៅពិន្ទុដោយជោគជ័យ!');
    }
}

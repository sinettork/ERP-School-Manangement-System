<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $classes = SchoolClass::orderBy('name')->get();
        $date    = $request->input('date', today()->toDateString());
        $classId = $request->input('class_id');

        $attendances = collect();
        $students    = collect();

        if ($classId) {
            $students = Student::where('class_id', $classId)
                ->where('status', 'active')
                ->orderBy('name_kh')
                ->get();

            $attendances = Attendance::where('class_id', $classId)
                ->where('date', $date)
                ->get()
                ->keyBy('student_id');
        }

        return view('attendance.index', compact('classes', 'date', 'classId', 'students', 'attendances'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date'     => 'required|date',
            'statuses' => 'required|array',
            'statuses.*' => 'required|in:present,absent,leave,late',
            'notes' => 'nullable|array',
            'notes.*' => 'nullable|string|max:1000',
        ]);

        $studentIds = array_keys($data['statuses']);
        $validStudentIds = Student::where('class_id', $data['class_id'])
            ->where('status', 'active')
            ->whereIn('id', $studentIds)
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->all();

        if (array_diff(array_map('strval', $studentIds), $validStudentIds)) {
            return back()->withErrors(['statuses' => 'វត្តមានត្រូវតែកត់ត្រាសម្រាប់សិស្សសកម្មក្នុងថ្នាក់ដែលបានជ្រើស។'])->withInput();
        }

        DB::transaction(function () use ($data) {
            foreach ($data['statuses'] as $studentId => $status) {
                Attendance::updateOrCreate(
                    ['student_id' => $studentId, 'class_id' => $data['class_id'], 'date' => $data['date']],
                    ['status' => $status, 'note' => $data['notes'][$studentId] ?? null, 'recorded_by' => auth()->id()]
                );
            }
        });

        return redirect()->back()->with('success', 'បានរក្សាទុកវត្តមានដោយជោគជ័យ!');
    }

    public function report(Request $request)
    {
        $classes    = SchoolClass::orderBy('name')->get();
        $classId    = $request->input('class_id');
        $month      = $request->input('month', today()->format('Y-m'));
        $report     = collect();

        if ($classId) {
            $students = Student::where('class_id', $classId)->where('status', 'active')->orderBy('name_kh')->get();
            $start    = Carbon::parse($month . '-01');
            $end      = $start->copy()->endOfMonth();
            $days     = [];
            for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
                $days[] = $d->format('Y-m-d');
            }

            $allAttendances = Attendance::where('class_id', $classId)
                ->whereBetween('date', [$start, $end])
                ->get()
                ->groupBy('student_id');

            foreach ($students as $student) {
                $records = $allAttendances->get($student->id, collect())->keyBy(fn($a) => $a->date->format('Y-m-d'));
                $report->push(['student' => $student, 'records' => $records, 'days' => $days]);
            }
        }

        return view('attendance.report', compact('classes', 'classId', 'month', 'report'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\LibraryBook;
use App\Models\Payment;
use App\Models\SchoolClass;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $activeYear = AcademicYear::where('is_active', true)->first();
        $today      = Carbon::today();

        $stats = [
            'students'        => Student::count(),
            'active_students' => Student::where('status', 'active')->count(),
            'teachers'        => Teacher::count(),
            'classes'         => $activeYear
                                    ? SchoolClass::where('academic_year_id', $activeYear->id)->count()
                                    : SchoolClass::count(),
            'academic_year'   => $activeYear?->name ?? 'មិនទាន់កំណត់',
            'subjects'        => Subject::count(),
            'staff'           => Staff::count(),
            'books'           => LibraryBook::sum('quantity'),
            'users'           => User::count(),
            'payments_today'  => Payment::whereDate('payment_date', $today)->count(),
            'present_today'   => Attendance::whereDate('date', $today)->where('status', 'present')->count(),
            'absent_today'    => Attendance::whereDate('date', $today)->where('status', 'absent')->count(),
            'late_today'      => Attendance::whereDate('date', $today)->where('status', 'late')->count(),
        ];

        $announcements = Announcement::latest()->take(5)->get();

        return view('dashboard', compact('stats', 'announcements'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Payment;
use App\Models\PaymentReceipt;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['student', 'academicYear', 'receivedBy'])->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('student', fn($q) => $q->where('name_kh', 'like', "%$s%")->orWhere('student_code', 'like', "%$s%"));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments      = $query->paginate(15)->withQueryString();
        $totalPaid     = Payment::where('status', 'paid')->sum('amount');
        $totalUnpaid   = Payment::where('status', 'unpaid')->sum('amount');

        return view('payments.index', compact('payments', 'totalPaid', 'totalUnpaid'));
    }

    public function create()
    {
        $students      = Student::where('status', 'active')->orderBy('name_kh')->get();
        $academicYears = AcademicYear::orderByDesc('start_date')->get();
        return view('payments.create', compact('students', 'academicYears'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id'       => 'required|exists:students,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'amount'           => 'required|numeric|min:0',
            'payment_type'     => 'required|in:monthly,quarterly,yearly',
            'period'           => 'nullable|string|max:50',
            'payment_date'     => 'required|date',
            'status'           => 'required|in:paid,partial,unpaid',
        ]);

        $data['received_by'] = auth()->id();
        $payment = Payment::create($data);

        if ($data['status'] === 'paid') {
            PaymentReceipt::create([
                'payment_id' => $payment->id,
                'receipt_no' => 'RCP-' . str_pad($payment->id, 6, '0', STR_PAD_LEFT),
            ]);
        }

        return redirect()->route('payments.index')
            ->with('success', 'បានកត់ត្រាការទូទាត់ដោយជោគជ័យ!');
    }

    public function show(Payment $payment)
    {
        $payment->load(['student', 'academicYear', 'receivedBy', 'receipt']);
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $students      = Student::where('status', 'active')->orderBy('name_kh')->get();
        $academicYears = AcademicYear::orderByDesc('start_date')->get();
        return view('payments.edit', compact('payment', 'students', 'academicYears'));
    }

    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'amount'       => 'required|numeric|min:0',
            'payment_type' => 'required|in:monthly,quarterly,yearly',
            'period'       => 'nullable|string|max:50',
            'payment_date' => 'required|date',
            'status'       => 'required|in:paid,partial,unpaid',
        ]);

        $payment->update($data);
        return redirect()->route('payments.index')
            ->with('success', 'បានកែប្រែការទូទាត់ដោយជោគជ័យ!');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')
            ->with('success', 'បានលុបការទូទាត់ដោយជោគជ័យ!');
    }

    public function receipt(Payment $payment)
    {
        $payment->load(['student', 'academicYear', 'receivedBy', 'receipt']);
        $pdf = Pdf::loadView('payments.receipt-pdf', compact('payment'))
            ->setPaper('a5', 'portrait');
        return $pdf->stream('receipt-' . ($payment->receipt->receipt_no ?? $payment->id) . '.pdf');
    }
}

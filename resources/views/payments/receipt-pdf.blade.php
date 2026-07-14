<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="utf-8"/>
    <style>
        body { font-family: 'Khmer OS', 'DejaVu Sans', sans-serif; font-size: 13px; color: #1e293b; margin: 20px; }
        .header { text-align: center; border-bottom: 2px solid #4f46e5; padding-bottom: 12px; margin-bottom: 16px; }
        .school-name { font-size: 18px; font-weight: bold; color: #4f46e5; }
        .receipt-title { font-size: 15px; font-weight: bold; margin: 8px 0 0; text-transform: uppercase; letter-spacing: 1px; }
        .receipt-no { font-size: 12px; color: #64748b; }
        table.info { width: 100%; margin-top: 12px; }
        table.info td { padding: 5px 0; vertical-align: top; }
        table.info td:first-child { width: 40%; color: #64748b; }
        .amount-box { background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; padding: 12px 16px; margin: 16px 0; text-align: center; }
        .amount-box .amount { font-size: 28px; font-weight: bold; color: #4f46e5; }
        .status-paid { display: inline-block; padding: 3px 10px; background: #dcfce7; color: #16a34a; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .footer { margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 12px; display: flex; justify-content: space-between; font-size: 11px; color: #94a3b8; }
        .signature { margin-top: 40px; display: flex; justify-content: space-between; }
        .sig-box { text-align: center; width: 45%; }
        .sig-line { border-top: 1px solid #334155; margin-top: 40px; padding-top: 6px; font-size: 11px; color: #64748b; }
    </style>
</head>
<body>
<div class="header">
    <div class="school-name">{{ \App\Models\SchoolInformation::first()?->school_name ?? 'សាលារៀន' }}</div>
    <div class="receipt-title">បង្កាន់ដៃទូទាត់</div>
    <div class="receipt-no">{{ $payment->receipt?->receipt_no ?? 'N/A' }}</div>
</div>

<table class="info">
    <tr><td>ឈ្មោះសិស្ស</td><td><strong>{{ $payment->student->name_kh }}</strong></td></tr>
    <tr><td>លេខកូដ</td><td>{{ $payment->student->student_code }}</td></tr>
    <tr><td>ថ្ងៃទូទាត់</td><td>{{ $payment->payment_date->format('d/m/Y') }}</td></tr>
    <tr><td>ប្រភេទ</td><td>{{ match($payment->payment_type){ 'monthly'=>'ប្រចាំខែ','quarterly'=>'ប្រចាំត្រីមាស',default=>'ប្រចាំឆ្នាំ' } }}</td></tr>
    @if($payment->period)<tr><td>រយៈពេល</td><td>{{ $payment->period }}</td></tr>@endif
    <tr><td>ឆ្នាំសិក្សា</td><td>{{ $payment->academicYear->name }}</td></tr>
    <tr><td>ទទួលដោយ</td><td>{{ $payment->receivedBy?->name ?? '—' }}</td></tr>
    <tr><td>ស្ថានភាព</td><td><span class="status-paid">{{ match($payment->status){ 'paid'=>'បានបង់','partial'=>'បង់មួយផ្នែក',default=>'មិនទាន់បង់' } }}</span></td></tr>
</table>

<div class="amount-box">
    <div style="font-size:12px;color:#64748b;margin-bottom:4px;">ចំនួនទឹកប្រាក់</div>
    <div class="amount">{{ number_format($payment->amount) }} ៛</div>
</div>

<div class="signature">
    <div class="sig-box">
        <div class="sig-line">អ្នកទូទាត់</div>
    </div>
    <div class="sig-box">
        <div class="sig-line">អ្នកទទួល</div>
    </div>
</div>

<div class="footer">
    <span>បោះពុម្ពថ្ងៃទី {{ now()->format('d/m/Y H:i') }}</span>
    <span>{{ \App\Models\SchoolInformation::first()?->phone }}</span>
</div>
</body>
</html>

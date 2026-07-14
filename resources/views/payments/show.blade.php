@extends('layouts.admin')
@section('title','ព័ត៌មានការទូទាត់')
@section('page-title','ព័ត៌មានការទូទាត់')

@section('content')
<div class="max-w-2xl space-y-5">
    <x-card>
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <p class="text-2xl font-bold text-indigo-700">{{ number_format($payment->amount) }} ៛</p>
                    <p class="text-sm text-slate-500 mt-0.5">{{ $payment->receipt?->receipt_no ?? 'គ្មានបង្កាន់ដៃ' }}</p>
                </div>
                <span class="px-3 py-1.5 rounded-full text-sm font-semibold
                    {{ $payment->status==='paid' ? 'bg-green-100 text-green-800' : ($payment->status==='partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                    {{ match($payment->status){ 'paid'=>'បានបង់','partial'=>'បង់មួយផ្នែក',default=>'មិនទាន់បង់' } }}
                </span>
            </div>
            <dl class="grid grid-cols-2 gap-3 text-sm">
                <div><dt class="text-slate-400">ឈ្មោះសិស្ស</dt><dd class="font-medium text-slate-800">{{ $payment->student->name_kh }}</dd></div>
                <div><dt class="text-slate-400">លេខកូដ</dt><dd class="font-mono text-slate-700">{{ $payment->student->student_code }}</dd></div>
                <div><dt class="text-slate-400">ប្រភេទ</dt><dd class="text-slate-700">{{ match($payment->payment_type){ 'monthly'=>'ប្រចាំខែ','quarterly'=>'ប្រចាំត្រីមាស',default=>'ប្រចាំឆ្នាំ' } }}</dd></div>
                <div><dt class="text-slate-400">ឆ្នាំសិក្សា</dt><dd class="text-slate-700">{{ $payment->academicYear->name }}</dd></div>
                <div><dt class="text-slate-400">ថ្ងៃទូទាត់</dt><dd class="text-slate-700">{{ $payment->payment_date->format('d/m/Y') }}</dd></div>
                <div><dt class="text-slate-400">ទទួលដោយ</dt><dd class="text-slate-700">{{ $payment->receivedBy?->name ?? '—' }}</dd></div>
                @if($payment->period)
                <div><dt class="text-slate-400">រយៈពេល</dt><dd class="text-slate-700">{{ $payment->period }}</dd></div>
                @endif
            </dl>
        </div>
    </x-card>
    <div class="flex gap-3">
        @if($payment->receipt)
        <a href="{{ route('payments.receipt',$payment) }}" target="_blank"
           class="inline-flex items-center gap-1.5 px-5 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            បោះពុម្ពបង្កាន់ដៃ
        </a>
        @endif
        <a href="{{ route('payments.edit',$payment) }}" class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg">កែប្រែ</a>
        <a href="{{ route('payments.index') }}" class="px-5 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg">ត្រឡប់</a>
    </div>
</div>
@endsection

@extends('layouts.admin')
@section('title','កែប្រែការទូទាត់')
@section('page-title','កែប្រែការទូទាត់')

@section('content')
<div class="max-w-xl mx-auto">
<form method="POST" action="{{ route('payments.update',$payment) }}">
@csrf @method('PUT')
<x-card>
    <div class="p-6 space-y-4">
        <div class="p-3 bg-slate-50 rounded-lg text-sm text-slate-600">
            <span class="font-medium">សិស្ស:</span> {{ $payment->student->name_kh }}
            ({{ $payment->student->student_code }}) — {{ $payment->academicYear->name }}
        </div>
        <div class="grid grid-cols-2 gap-4">
            <x-form-input label="ចំនួនទឹកប្រាក់ (៛)" name="amount" type="number" :required="true" :value="$payment->amount"/>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">ប្រភេទ <span class="text-red-500">*</span></label>
                <select name="payment_type" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="monthly"   {{ $payment->payment_type=='monthly'   ? 'selected':'' }}>ប្រចាំខែ</option>
                    <option value="quarterly" {{ $payment->payment_type=='quarterly' ? 'selected':'' }}>ប្រចាំត្រីមាស</option>
                    <option value="yearly"    {{ $payment->payment_type=='yearly'    ? 'selected':'' }}>ប្រចាំឆ្នាំ</option>
                </select>
            </div>
        </div>
        <x-form-input label="រយៈពេល" name="period" :value="$payment->period"/>
        <x-form-input label="ថ្ងៃទូទាត់" name="payment_date" type="date" :required="true" :value="$payment->payment_date->format('Y-m-d')"/>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">ស្ថានភាព <span class="text-red-500">*</span></label>
            <select name="status" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="paid"    {{ $payment->status=='paid'    ? 'selected':'' }}>បានបង់</option>
                <option value="partial" {{ $payment->status=='partial' ? 'selected':'' }}>បង់មួយផ្នែក</option>
                <option value="unpaid"  {{ $payment->status=='unpaid'  ? 'selected':'' }}>មិនទាន់បង់</option>
            </select>
        </div>
    </div>
    <div class="flex gap-3 px-6 pb-6">
        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">រក្សាទុក</button>
        <a href="{{ route('payments.index') }}" class="px-6 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg">បោះបង់</a>
    </div>
</x-card>
</form>
</div>
@endsection

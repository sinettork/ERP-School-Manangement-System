@extends('layouts.admin')
@section('title','ថ្មី — ថ្លៃសិក្សា')
@section('page-title','កត់ត្រាការទូទាត់ថ្មី')

@section('content')
<div class="max-w-xl mx-auto">
<form method="POST" action="{{ route('payments.store') }}">
@csrf
<x-card>
    <div class="p-6 space-y-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">សិស្ស <span class="text-red-500">*</span></label>
            <select name="student_id" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('student_id') border-red-300 @enderror">
                <option value="">-- ជ្រើសសិស្ស --</option>
                @foreach($students as $s)
                    <option value="{{ $s->id }}" {{ old('student_id')==$s->id ? 'selected':'' }}>{{ $s->name_kh }} ({{ $s->student_code }})</option>
                @endforeach
            </select>
            @error('student_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">ឆ្នាំសិក្សា <span class="text-red-500">*</span></label>
            <select name="academic_year_id" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">-- ជ្រើស --</option>
                @foreach($academicYears as $y)
                    <option value="{{ $y->id }}" {{ (old('academic_year_id', $y->is_active ? $y->id : ''))==$y->id ? 'selected':'' }}>{{ $y->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <x-form-input label="ចំនួនទឹកប្រាក់ (៛)" name="amount" type="number" :required="true" :value="old('amount')"/>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">ប្រភេទ <span class="text-red-500">*</span></label>
                <select name="payment_type" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="monthly"   {{ old('payment_type','monthly')=='monthly'   ? 'selected':'' }}>ប្រចាំខែ</option>
                    <option value="quarterly" {{ old('payment_type')=='quarterly' ? 'selected':'' }}>ប្រចាំត្រីមាស</option>
                    <option value="yearly"    {{ old('payment_type')=='yearly'    ? 'selected':'' }}>ប្រចាំឆ្នាំ</option>
                </select>
            </div>
        </div>
        <x-form-input label="រយៈពេល" name="period" :value="old('period')" placeholder="ឧ. ខែមករា ២០២៥"/>
        <x-form-input label="ថ្ងៃទូទាត់" name="payment_date" type="date" :required="true" :value="old('payment_date', today()->toDateString())"/>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">ស្ថានភាព <span class="text-red-500">*</span></label>
            <select name="status" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="paid"    {{ old('status','paid')=='paid'    ? 'selected':'' }}>បានបង់</option>
                <option value="partial" {{ old('status')=='partial' ? 'selected':'' }}>បង់មួយផ្នែក</option>
                <option value="unpaid"  {{ old('status')=='unpaid'  ? 'selected':'' }}>មិនទាន់បង់</option>
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

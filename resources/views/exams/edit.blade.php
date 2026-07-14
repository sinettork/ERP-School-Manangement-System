@extends('layouts.admin')
@section('title','កែប្រែការប្រឡង')
@section('page-title','កែប្រែការប្រឡង')

@section('content')
<div class="max-w-lg mx-auto">
<form method="POST" action="{{ route('exams.update',$exam) }}">
@csrf @method('PUT')
<x-card>
    <div class="p-6 space-y-4">
        <x-form-input label="ឈ្មោះការប្រឡង" name="name" :required="true" :value="$exam->name"/>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">ប្រភេទ <span class="text-red-500">*</span></label>
            <select name="exam_type" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="monthly"  {{ $exam->exam_type=='monthly'  ? 'selected':'' }}>ប្រចាំខែ</option>
                <option value="midterm"  {{ $exam->exam_type=='midterm'  ? 'selected':'' }}>មធ្យមភាគ</option>
                <option value="final"    {{ $exam->exam_type=='final'    ? 'selected':'' }}>ចុងឆមាស</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">ឆ្នាំសិក្សា <span class="text-red-500">*</span></label>
            <select name="academic_year_id" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                @foreach($academicYears as $y)
                    <option value="{{ $y->id }}" {{ $exam->academic_year_id==$y->id ? 'selected':'' }}>{{ $y->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">ឆមាស</label>
            <select name="semester_id" class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">-- គ្មាន --</option>
                @foreach($semesters as $sem)
                    <option value="{{ $sem->id }}" {{ $exam->semester_id==$sem->id ? 'selected':'' }}>
                        {{ $sem->academicYear->name }} — {{ $sem->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <x-form-input label="ថ្ងៃចាប់ផ្ដើម" name="start_date" type="date" :value="$exam->start_date?->format('Y-m-d')"/>
            <x-form-input label="ថ្ងៃបញ្ចប់"   name="end_date"   type="date" :value="$exam->end_date?->format('Y-m-d')"/>
        </div>
    </div>
    <div class="flex gap-3 px-6 pb-6">
        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">រក្សាទុក</button>
        <a href="{{ route('exams.index') }}" class="px-6 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg">បោះបង់</a>
    </div>
</x-card>
</form>
</div>
@endsection

@extends('layouts.admin')
@section('title','បន្ថែមសិស្ស')
@section('page-title','បន្ថែមសិស្សថ្មី')

@section('content')
<div class="max-w-3xl mx-auto">
<form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data">
@csrf
<x-card>
    <div class="p-6 space-y-5">
        <h3 class="font-semibold text-slate-700 border-b pb-2">ព័ត៌មានផ្ទាល់ខ្លួន</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-form-input label="លេខកូដសិស្ស" name="student_code" :required="true" :value="old('student_code')" placeholder="ឧ. STU-2025-001"/>
            <x-form-input label="ឈ្មោះ (ខ្មែរ)" name="name_kh" :required="true" :value="old('name_kh')"/>
            <x-form-input label="ឈ្មោះ (អង់គ្លេស)" name="name_en" :value="old('name_en')"/>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">ភេទ <span class="text-red-500">*</span></label>
                <select name="gender" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('gender') border-red-300 @enderror">
                    <option value="">-- ជ្រើស --</option>
                    <option value="male"   {{ old('gender')=='male'   ? 'selected' : '' }}>ប្រុស</option>
                    <option value="female" {{ old('gender')=='female' ? 'selected' : '' }}>ស្រី</option>
                </select>
                @error('gender')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <x-form-input label="ថ្ងៃខែឆ្នាំកំណើត" name="dob" type="date" :value="old('dob')"/>
            <x-form-input label="ទូរស័ព្ទ" name="phone" :value="old('phone')"/>
        </div>
        <x-form-input label="អាសយដ្ឋាន" name="address" :value="old('address')"/>

        <h3 class="font-semibold text-slate-700 border-b pb-2 pt-2">ព័ត៌មានគ្រួសារ</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-form-input label="ឈ្មោះឪពុក" name="father_name" :value="old('father_name')"/>
            <x-form-input label="ឈ្មោះម្ដាយ" name="mother_name" :value="old('mother_name')"/>
        </div>

        <h3 class="font-semibold text-slate-700 border-b pb-2 pt-2">ព័ត៌មានការចុះឈ្មោះ</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">ថ្នាក់រៀន</label>
                <select name="class_id" class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">-- ជ្រើស --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">ឆ្នាំសិក្សា</label>
                <select name="academic_year_id" class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">-- ជ្រើស --</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}" {{ (old('academic_year_id', $year->is_active ? $year->id : '') == $year->id) ? 'selected' : '' }}>{{ $year->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">ស្ថានភាព <span class="text-red-500">*</span></label>
                <select name="status" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="active"   {{ old('status','active')=='active'   ? 'selected' : '' }}>សកម្ម</option>
                    <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>អសកម្ម</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">រូបថត</label>
                <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
            </div>
        </div>
    </div>
    <div class="flex gap-3 px-6 pb-6">
        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">រក្សាទុក</button>
        <a href="{{ route('students.index') }}" class="px-6 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg">បោះបង់</a>
    </div>
</x-card>
</form>
</div>
@endsection

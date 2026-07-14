@extends('layouts.admin')
@section('title','បន្ថែមថ្នាក់រៀន')
@section('page-title','បន្ថែមថ្នាក់រៀនថ្មី')

@section('content')
<div class="max-w-xl mx-auto">
<form method="POST" action="{{ route('classes.store') }}">
@csrf
<x-card>
    <div class="p-6 space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-form-input label="ឈ្មោះថ្នាក់"      name="name"        :required="true" :value="old('name')" placeholder="ឧ. ថ្នាក់ទី៧A"/>
            <x-form-input label="ថ្នាក់ទី"           name="grade_level" :required="true" :value="old('grade_level')" placeholder="ឧ. ៧"/>
            <x-form-input label="បន្ទប់"             name="room"        :value="old('room')"/>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">វេន <span class="text-red-500">*</span></label>
                <select name="shift" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="morning"   {{ old('shift','morning')=='morning'   ? 'selected':'' }}>ព្រឹក</option>
                    <option value="afternoon" {{ old('shift')=='afternoon' ? 'selected':'' }}>រសៀល</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">គ្រូប្រចាំថ្នាក់</label>
                <select name="homeroom_teacher_id" class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">-- ជ្រើស --</option>
                    @foreach($teachers as $t)
                        <option value="{{ $t->id }}" {{ old('homeroom_teacher_id')==$t->id ? 'selected':'' }}>{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
            <x-form-input label="ចំនួនសិស្សអតិបរិមា" name="max_students" type="number" :required="true" :value="old('max_students','40')"/>
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">ឆ្នាំសិក្សា <span class="text-red-500">*</span></label>
                <select name="academic_year_id" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">-- ជ្រើស --</option>
                    @foreach($academicYears as $y)
                        <option value="{{ $y->id }}" {{ (old('academic_year_id', $y->is_active ? $y->id : ''))==$y->id ? 'selected':'' }}>{{ $y->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="flex gap-3 px-6 pb-6">
        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">រក្សាទុក</button>
        <a href="{{ route('classes.index') }}" class="px-6 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg">បោះបង់</a>
    </div>
</x-card>
</form>
</div>
@endsection

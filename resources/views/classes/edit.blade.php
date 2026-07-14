@extends('layouts.admin')
@section('title','កែប្រែថ្នាក់រៀន')
@section('page-title','កែប្រែថ្នាក់រៀន')

@section('content')
<div class="max-w-xl mx-auto">
<form method="POST" action="{{ route('classes.update',$class) }}">
@csrf @method('PUT')
<x-card>
    <div class="p-6 space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-form-input label="ឈ្មោះថ្នាក់"      name="name"        :required="true" :value="$class->name"/>
            <x-form-input label="ថ្នាក់ទី"           name="grade_level" :required="true" :value="$class->grade_level"/>
            <x-form-input label="បន្ទប់"             name="room"        :value="$class->room"/>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">វេន <span class="text-red-500">*</span></label>
                <select name="shift" required class="block w-full rounded-lg border-slate-300 text-sm">
                    <option value="morning"   {{ $class->shift=='morning'   ? 'selected':'' }}>ព្រឹក</option>
                    <option value="afternoon" {{ $class->shift=='afternoon' ? 'selected':'' }}>រសៀល</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">គ្រូប្រចាំថ្នាក់</label>
                <select name="homeroom_teacher_id" class="block w-full rounded-lg border-slate-300 text-sm">
                    <option value="">-- គ្មាន --</option>
                    @foreach($teachers as $t)
                        <option value="{{ $t->id }}" {{ $class->homeroom_teacher_id==$t->id ? 'selected':'' }}>{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
            <x-form-input label="ចំនួនសិស្សអតិបរិមា" name="max_students" type="number" :required="true" :value="$class->max_students"/>
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">ឆ្នាំសិក្សា <span class="text-red-500">*</span></label>
                <select name="academic_year_id" required class="block w-full rounded-lg border-slate-300 text-sm">
                    @foreach($academicYears as $y)
                        <option value="{{ $y->id }}" {{ $class->academic_year_id==$y->id ? 'selected':'' }}>{{ $y->name }}</option>
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

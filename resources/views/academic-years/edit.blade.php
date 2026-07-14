@extends('layouts.admin')
@section('title','កែប្រែឆ្នាំសិក្សា')
@section('page-title','កែប្រែឆ្នាំសិក្សា')

@section('content')
<div class="max-w-xl mx-auto">
    <x-card>
        <form method="POST" action="{{ route('academic-years.update', $academicYear) }}" class="p-6 space-y-5">
            @csrf @method('PUT')
            <x-form-input label="ឆ្នាំសិក្សា" name="name" :required="true" :value="$academicYear->name"/>
            <x-form-input label="ថ្ងៃចាប់ផ្ដើម" name="start_date" type="date" :required="true" :value="$academicYear->start_date->format('Y-m-d')"/>
            <x-form-input label="ថ្ងៃបញ្ចប់"   name="end_date"   type="date" :required="true" :value="$academicYear->end_date->format('Y-m-d')"/>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ $academicYear->is_active ? 'checked' : '' }} class="rounded border-slate-300 text-indigo-600">
                <label for="is_active" class="text-sm text-slate-700">កំណត់ជាឆ្នាំសិក្សាបច្ចុប្បន្ន</label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">រក្សាទុក</button>
                <a href="{{ route('academic-years.index') }}" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg">បោះបង់</a>
            </div>
        </form>
    </x-card>
</div>
@endsection

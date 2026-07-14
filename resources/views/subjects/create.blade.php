@extends('layouts.admin')
@section('title','បន្ថែមមុខវិជ្ជា')
@section('page-title','បន្ថែមមុខវិជ្ជាថ្មី')

@section('content')
<div class="max-w-lg mx-auto">
<form method="POST" action="{{ route('subjects.store') }}">
@csrf
<x-card>
    <div class="p-6 space-y-4">
        <x-form-input label="លេខកូដ"         name="code"    :required="true" :value="old('code')" placeholder="ឧ. KH001"/>
        <x-form-input label="ឈ្មោះ (ខ្មែរ)"  name="name_kh" :required="true" :value="old('name_kh')"/>
        <x-form-input label="ឈ្មោះ (អង់គ្លេស)" name="name_en" :required="true" :value="old('name_en')"/>
    </div>
    <div class="flex gap-3 px-6 pb-6">
        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">រក្សាទុក</button>
        <a href="{{ route('subjects.index') }}" class="px-6 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg">បោះបង់</a>
    </div>
</x-card>
</form>
</div>
@endsection

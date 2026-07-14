@extends('layouts.admin')
@section('title','កែប្រែបុគ្គលិក')
@section('page-title','កែប្រែបុគ្គលិក')

@section('content')
<div class="max-w-lg mx-auto">
<form method="POST" action="{{ route('staff.update',$staff) }}">
@csrf @method('PUT')
<x-card>
    <div class="p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <x-form-input label="លេខកូដ" name="staff_code" :required="true" :value="$staff->staff_code"/>
            <x-form-input label="ឈ្មោះ"  name="name"       :required="true" :value="$staff->name"/>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">មុខតំណែង</label>
            <select name="position" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="office"   {{ $staff->position=='office'   ? 'selected':'' }}>ការិយាល័យ</option>
                <option value="cleaner"  {{ $staff->position=='cleaner'  ? 'selected':'' }}>អ្នកសំអាត</option>
                <option value="security" {{ $staff->position=='security' ? 'selected':'' }}>សន្តិសុខ</option>
                <option value="other"    {{ $staff->position=='other'    ? 'selected':'' }}>ផ្សេង</option>
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <x-form-input label="ទូរស័ព្ទ"     name="phone"  :value="$staff->phone"/>
            <x-form-input label="ប្រាក់ខែ (៛)" name="salary" type="number" :value="$staff->salary"/>
        </div>
    </div>
    <div class="flex gap-3 px-6 pb-6">
        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">រក្សាទុក</button>
        <a href="{{ route('staff.index') }}" class="px-6 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg">បោះបង់</a>
    </div>
</x-card>
</form>
</div>
@endsection

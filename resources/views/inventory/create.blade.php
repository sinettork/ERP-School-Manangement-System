@extends('layouts.admin')
@section('title','បន្ថែមសម្ភារៈ')
@section('page-title','បន្ថែមសម្ភារៈថ្មី')

@section('content')
<div class="max-w-lg mx-auto">
<form method="POST" action="{{ route('inventory.store') }}">
@csrf
<x-card>
    <div class="p-6 space-y-4">
        <x-form-input label="ឈ្មោះ" name="name" :required="true" :value="old('name')"/>
        <div class="grid grid-cols-2 gap-4">
            <x-form-input label="ប្រភេទ"    name="category" :value="old('category')"/>
            <x-form-input label="ចំនួន"     name="quantity" type="number" :required="true" :value="old('quantity','1')"/>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">ស្ថានភាព <span class="text-red-500">*</span></label>
                <select name="condition" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="good"    {{ old('condition','good')=='good'    ? 'selected':'' }}>ល្អ</option>
                    <option value="fair"    {{ old('condition')=='fair'    ? 'selected':'' }}>មធ្យម</option>
                    <option value="poor"    {{ old('condition')=='poor'    ? 'selected':'' }}>ខ្សោយ</option>
                    <option value="damaged" {{ old('condition')=='damaged' ? 'selected':'' }}>ខូច</option>
                </select>
            </div>
            <x-form-input label="ទីតាំង" name="location" :value="old('location')"/>
        </div>
        <x-form-input label="ថ្ងៃទិញ" name="purchased_date" type="date" :value="old('purchased_date')"/>
    </div>
    <div class="flex gap-3 px-6 pb-6">
        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">រក្សាទុក</button>
        <a href="{{ route('inventory.index') }}" class="px-6 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg">បោះបង់</a>
    </div>
</x-card>
</form>
</div>
@endsection

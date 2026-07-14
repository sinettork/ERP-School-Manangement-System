@extends('layouts.admin')
@section('title','បន្ថែមសៀវភៅ')
@section('page-title','បន្ថែមសៀវភៅថ្មី')

@section('content')
<div class="max-w-xl mx-auto">
<form method="POST" action="{{ route('library.store') }}">
@csrf
<x-card>
    <div class="p-6 space-y-4">
        <x-form-input label="ចំណងជើង" name="title"  :required="true" :value="old('title')"/>
        <x-form-input label="អ្នកនិពន្ធ" name="author" :value="old('author')"/>
        <div class="grid grid-cols-2 gap-4">
            <x-form-input label="ISBN"    name="isbn"     :value="old('isbn')"/>
            <x-form-input label="ប្រភេទ" name="category" :value="old('category')"/>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <x-form-input label="ចំនួនសរុប" name="quantity"           type="number" :required="true" :value="old('quantity','1')"/>
            <x-form-input label="ចំនួនអាចខ្ចី" name="available_quantity" type="number" :required="true" :value="old('available_quantity','1')"/>
        </div>
        <x-form-input label="ទីតាំងជាន់/ជួរ" name="shelf_location" :value="old('shelf_location')"/>
    </div>
    <div class="flex gap-3 px-6 pb-6">
        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">រក្សាទុក</button>
        <a href="{{ route('library.index') }}" class="px-6 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg">បោះបង់</a>
    </div>
</x-card>
</form>
</div>
@endsection

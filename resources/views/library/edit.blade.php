@extends('layouts.admin')
@section('title','កែប្រែសៀវភៅ')
@section('page-title','កែប្រែសៀវភៅ')

@section('content')
<div class="max-w-xl mx-auto">
<form method="POST" action="{{ route('library.update',$library) }}">
@csrf @method('PUT')
<x-card>
    <div class="p-6 space-y-4">
        <x-form-input label="ចំណងជើង" name="title"  :required="true" :value="$library->title"/>
        <x-form-input label="អ្នកនិពន្ធ" name="author" :value="$library->author"/>
        <div class="grid grid-cols-2 gap-4">
            <x-form-input label="ISBN"    name="isbn"     :value="$library->isbn"/>
            <x-form-input label="ប្រភេទ" name="category" :value="$library->category"/>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <x-form-input label="ចំនួនសរុប"  name="quantity"           type="number" :required="true" :value="$library->quantity"/>
            <x-form-input label="ចំនួនអាចខ្ចី" name="available_quantity" type="number" :required="true" :value="$library->available_quantity"/>
        </div>
        <x-form-input label="ទីតាំង" name="shelf_location" :value="$library->shelf_location"/>
    </div>
    <div class="flex gap-3 px-6 pb-6">
        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">រក្សាទុក</button>
        <a href="{{ route('library.index') }}" class="px-6 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg">បោះបង់</a>
    </div>
</x-card>
</form>
</div>
@endsection

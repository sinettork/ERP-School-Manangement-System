@extends('layouts.admin')
@section('title','បន្ថែមសេចក្ដីជូនដំណឹង')
@section('page-title','បន្ថែមសេចក្ដីជូនដំណឹងថ្មី')

@section('content')
<div class="max-w-2xl mx-auto">
<form method="POST" action="{{ route('announcements.store') }}">
@csrf
<x-card>
    <div class="p-6 space-y-4">
        <x-form-input label="ចំណងជើង" name="title" :required="true" :value="old('title')"/>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">ផ្ញើទៅ <span class="text-red-500">*</span></label>
            <select name="target_role" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="all"     {{ old('target_role','all')=='all'     ? 'selected':'' }}>ទាំងអស់</option>
                <option value="teacher" {{ old('target_role')=='teacher' ? 'selected':'' }}>គ្រូបង្រៀន</option>
                <option value="student" {{ old('target_role')=='student' ? 'selected':'' }}>សិស្ស</option>
                <option value="parent"  {{ old('target_role')=='parent'  ? 'selected':'' }}>អាណាព្យាបាល</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">មាតិកា <span class="text-red-500">*</span></label>
            <textarea name="content" rows="8" required
                      class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('content') border-red-300 @enderror"
                      placeholder="សរសេរមាតិកានៅទីនេះ...">{{ old('content') }}</textarea>
            @error('content')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
    </div>
    <div class="flex gap-3 px-6 pb-6">
        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">ផ្សព្វផ្សាយ</button>
        <a href="{{ route('announcements.index') }}" class="px-6 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg">បោះបង់</a>
    </div>
</x-card>
</form>
</div>
@endsection

@extends('layouts.admin')
@section('title','កែប្រែគ្រូ')
@section('page-title','កែប្រែព័ត៌មានគ្រូបង្រៀន')

@section('content')
<div class="max-w-2xl mx-auto">
<form method="POST" action="{{ route('teachers.update',$teacher) }}" enctype="multipart/form-data">
@csrf @method('PUT')
<x-card>
    <div class="p-6 space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-form-input label="លេខកូដគ្រូ" name="teacher_code" :required="true" :value="$teacher->teacher_code"/>
            <x-form-input label="ឈ្មោះ"        name="name"        :required="true" :value="$teacher->name"/>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">ភេទ <span class="text-red-500">*</span></label>
                <select name="gender" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="male"   {{ $teacher->gender=='male'   ? 'selected':'' }}>ប្រុស</option>
                    <option value="female" {{ $teacher->gender=='female' ? 'selected':'' }}>ស្រី</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">មុខតំណែង <span class="text-red-500">*</span></label>
                <select name="position" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="subject"  {{ $teacher->position=='subject'  ? 'selected':'' }}>គ្រូមុខវិជ្ជា</option>
                    <option value="homeroom" {{ $teacher->position=='homeroom' ? 'selected':'' }}>គ្រូប្រចាំថ្នាក់</option>
                </select>
            </div>
            <x-form-input label="ទូរស័ព្ទ"    name="phone"  :value="$teacher->phone"/>
            <x-form-input label="អ៊ីមែល"       name="email"  type="email" :value="$teacher->email"/>
            <x-form-input label="ប្រាក់ខែ (៛)" name="salary" type="number" :value="$teacher->salary"/>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">រូបថតថ្មី</label>
                <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700"/>
            </div>
        </div>
        <x-form-input label="អាសយដ្ឋាន" name="address" :value="$teacher->address"/>
    </div>
    <div class="flex gap-3 px-6 pb-6">
        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">រក្សាទុក</button>
        <a href="{{ route('teachers.index') }}" class="px-6 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg">បោះបង់</a>
    </div>
</x-card>
</form>
</div>
@endsection

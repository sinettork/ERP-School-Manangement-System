@extends('layouts.admin')
@section('title','បន្ថែមគ្រូ')
@section('page-title','បន្ថែមគ្រូបង្រៀនថ្មី')

@section('content')
<div class="max-w-2xl mx-auto">
<form method="POST" action="{{ route('teachers.store') }}" enctype="multipart/form-data">
@csrf
<x-card>
    <div class="p-6 space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-form-input label="លេខកូដគ្រូ"    name="teacher_code" :required="true" :value="old('teacher_code')" placeholder="ឧ. TCH-001"/>
            <x-form-input label="ឈ្មោះ"           name="name"         :required="true" :value="old('name')"/>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">ភេទ <span class="text-red-500">*</span></label>
                <select name="gender" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">-- ជ្រើស --</option>
                    <option value="male"   {{ old('gender')=='male'   ? 'selected':'' }}>ប្រុស</option>
                    <option value="female" {{ old('gender')=='female' ? 'selected':'' }}>ស្រី</option>
                </select>
                @error('gender')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">មុខតំណែង <span class="text-red-500">*</span></label>
                <select name="position" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="subject"  {{ old('position','subject')=='subject'  ? 'selected':'' }}>គ្រូមុខវិជ្ជា</option>
                    <option value="homeroom" {{ old('position')=='homeroom' ? 'selected':'' }}>គ្រូប្រចាំថ្នាក់</option>
                </select>
            </div>
            <x-form-input label="ទូរស័ព្ទ"    name="phone"   :value="old('phone')"/>
            <x-form-input label="អ៊ីមែល"       name="email"   type="email" :value="old('email')"/>
            <x-form-input label="ប្រាក់ខែ (៛)" name="salary"  type="number" :value="old('salary','0')"/>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">រូបថត</label>
                <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700"/>
            </div>
        </div>
        <x-form-input label="អាសយដ្ឋាន" name="address" :value="old('address')"/>

        <div class="border-t pt-4">
            <div class="flex items-center gap-2 mb-3">
                <input type="checkbox" id="create_user" name="create_user" value="1" {{ old('create_user') ? 'checked':'' }}
                       x-on:change="$refs.userFields.classList.toggle('hidden')"
                       class="rounded border-slate-300 text-indigo-600">
                <label for="create_user" class="text-sm font-medium text-slate-700">បង្កើតគណនីចូលប្រើប្រាស់ផងដែរ</label>
            </div>
            <div x-ref="userFields" class="{{ old('create_user') ? '' : 'hidden' }} grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-form-input label="ពាក្យសម្ងាត់" name="password" type="password" placeholder="យ៉ាងតិច ៨ តួ"/>
            </div>
        </div>
    </div>
    <div class="flex gap-3 px-6 pb-6">
        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">រក្សាទុក</button>
        <a href="{{ route('teachers.index') }}" class="px-6 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg">បោះបង់</a>
    </div>
</x-card>
</form>
</div>
@endsection

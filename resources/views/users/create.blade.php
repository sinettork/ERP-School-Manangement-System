@extends('layouts.admin')
@section('title','បន្ថែមអ្នកប្រើប្រាស់')
@section('page-title','បន្ថែមអ្នកប្រើប្រាស់ថ្មី')

@section('content')
<div class="max-w-xl mx-auto">
<form method="POST" action="{{ route('users.store') }}">
@csrf
<x-card>
    <div class="p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <x-form-input label="ឈ្មោះ"  name="name"  :required="true" :value="old('name')"/>
            <x-form-input label="អ៊ីមែល" name="email" type="email" :required="true" :value="old('email')"/>
        </div>
        <x-form-input label="ទូរស័ព្ទ" name="phone" :value="old('phone')"/>
        <div class="grid grid-cols-2 gap-4">
            <x-form-input label="ពាក្យសម្ងាត់"    name="password"              type="password" :required="true"/>
            <x-form-input label="បញ្ជាក់ម្ដងទៀត" name="password_confirmation" type="password" :required="true"/>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">តួនាទី <span class="text-red-500">*</span></label>
                <select name="role" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">-- ជ្រើស --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role')==$role->name ? 'selected':'' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">ស្ថានភាព <span class="text-red-500">*</span></label>
                <select name="status" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="active"   {{ old('status','active')=='active'   ? 'selected':'' }}>សកម្ម</option>
                    <option value="inactive" {{ old('status')=='inactive' ? 'selected':'' }}>អសកម្ម</option>
                </select>
            </div>
        </div>
    </div>
    <div class="flex gap-3 px-6 pb-6">
        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">រក្សាទុក</button>
        <a href="{{ route('users.index') }}" class="px-6 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg">បោះបង់</a>
    </div>
</x-card>
</form>
</div>
@endsection

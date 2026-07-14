@extends('layouts.admin')
@section('title','កែប្រែអ្នកប្រើប្រាស់')
@section('page-title','កែប្រែអ្នកប្រើប្រាស់')

@section('content')
<div class="max-w-xl mx-auto">
<form method="POST" action="{{ route('users.update',$user) }}">
@csrf @method('PUT')
<x-card>
    <div class="p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <x-form-input label="ឈ្មោះ"  name="name"  :required="true" :value="$user->name"/>
            <x-form-input label="អ៊ីមែល" name="email" type="email" :required="true" :value="$user->email"/>
        </div>
        <x-form-input label="ទូរស័ព្ទ" name="phone" :value="$user->phone"/>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">តួនាទី <span class="text-red-500">*</span></label>
                <select name="role" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected':'' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">ស្ថានភាព <span class="text-red-500">*</span></label>
                <select name="status" required class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="active"   {{ $user->status=='active'   ? 'selected':'' }}>សកម្ម</option>
                    <option value="inactive" {{ $user->status=='inactive' ? 'selected':'' }}>អសកម្ម</option>
                </select>
            </div>
        </div>
        <div class="border-t pt-4">
            <p class="text-sm text-slate-500 mb-3">ផ្លាស់ប្ដូរពាក្យសម្ងាត់ (ទុកទទេ ប្រសិនមិនផ្លាស់ប្ដូរ)</p>
            <div class="grid grid-cols-2 gap-4">
                <x-form-input label="ពាក្យសម្ងាត់ថ្មី"    name="password"              type="password"/>
                <x-form-input label="បញ្ជាក់ម្ដងទៀត" name="password_confirmation" type="password"/>
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

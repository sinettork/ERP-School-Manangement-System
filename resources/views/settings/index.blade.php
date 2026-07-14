@extends('layouts.admin')
@section('title','ការកំណត់')
@section('page-title','ការកំណត់ប្រព័ន្ធ')

@section('content')
<div class="max-w-2xl mx-auto">
<form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
@csrf

<div class="space-y-5">

    {{-- School info --}}
    <x-card>
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800">ព័ត៌មានសាលារៀន</h3>
        </div>
        <div class="p-6 space-y-4">
            @if($school?->logo)
            <div class="flex items-center gap-4">
                <img src="{{ Storage::url($school->logo) }}" alt="logo" class="w-16 h-16 rounded-lg object-cover border border-slate-200"/>
                <span class="text-sm text-slate-500">រូបភាពបច្ចុប្បន្ន</span>
            </div>
            @endif
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">លេចខ្ទឹម/លក្ខណ</label>
                <input type="file" name="logo" accept="image/*"
                       class="block w-full text-sm text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700"/>
            </div>
            <x-form-input label="ឈ្មោះសាលា"  name="school_name" :required="true" :value="$school?->school_name"/>
            <x-form-input label="អាសយដ្ឋាន"   name="address"     :required="true" :value="$school?->address"/>
            <div class="grid grid-cols-2 gap-4">
                <x-form-input label="ទូរស័ព្ទ" name="phone" :required="true" :value="$school?->phone"/>
                <x-form-input label="អ៊ីមែល"   name="email" type="email"      :value="$school?->email"/>
            </div>
        </div>
    </x-card>

    {{-- System settings --}}
    <x-card>
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800">ការកំណត់ប្រព័ន្ធ</h3>
        </div>
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <x-form-input
                    label="ចំនួនជួរក្នុងមួយទំព័រ"
                    name="items_per_page"
                    type="number"
                    :required="true"
                    :value="$settings->get('items_per_page', 15)"
                />
                <x-form-input
                    label="និមិត្តសញ្ញារូបិយប័ណ្ណ"
                    name="currency_symbol"
                    :required="true"
                    :value="$settings->get('currency_symbol', '៛')"
                />
            </div>
        </div>
    </x-card>

    <div class="flex gap-3">
        <button type="submit" class="inline-flex items-center gap-1.5 px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
            រក្សាទុក
        </button>
    </div>
</div>
</form>
</div>
@endsection

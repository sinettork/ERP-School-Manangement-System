@extends('layouts.admin')
@section('title','ព័ត៌មានថ្នាក់')
@section('page-title','ព័ត៌មានថ្នាក់រៀន')

@section('content')
<div class="space-y-5">
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-5">
        <x-card class="p-5">
            <p class="text-xs text-slate-500">ឈ្មោះថ្នាក់</p>
            <p class="text-2xl font-bold text-slate-800 mt-1">{{ $class->name }}</p>
        </x-card>
        <x-card class="p-5">
            <p class="text-xs text-slate-500">ចំនួនសិស្ស</p>
            <p class="text-2xl font-bold text-indigo-600 mt-1">{{ $class->students->count() }} / {{ $class->max_students }}</p>
        </x-card>
        <x-card class="p-5">
            <p class="text-xs text-slate-500">គ្រូប្រចាំថ្នាក់</p>
            <p class="text-lg font-semibold text-slate-800 mt-1">{{ $class->homeroomTeacher?->name ?? '—' }}</p>
        </x-card>
        <x-card class="p-5">
            <p class="text-xs text-slate-500">វេន</p>
            <p class="text-lg font-semibold text-slate-800 mt-1">{{ $class->shift==='morning' ? 'ព្រឹក' : 'រសៀល' }}</p>
        </x-card>
    </div>

    <x-card>
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h3 class="font-semibold text-slate-700">សិស្ស ({{ $class->students->count() }})</h3>
            <a href="{{ route('students.create') }}" class="text-sm text-indigo-600 hover:text-indigo-700">+ បន្ថែមសិស្ស</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50"><tr>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">លេខកូដ</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ឈ្មោះ</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ភេទ</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ស្ថានភាព</th>
                </tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($class->students as $s)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-mono text-xs text-slate-500">{{ $s->student_code }}</td>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $s->name_kh }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $s->gender==='male' ? 'ប្រុស' : 'ស្រី' }}</td>
                        <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $s->status==='active' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">{{ $s->status==='active' ? 'សកម្ម' : 'អសកម្ម' }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-slate-400">មិនទាន់មានសិស្ស</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</div>
@endsection

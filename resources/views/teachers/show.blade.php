@extends('layouts.admin')
@section('title','ព័ត៌មានគ្រូ')
@section('page-title','ព័ត៌មានគ្រូបង្រៀន')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <x-card class="p-6 text-center lg:col-span-1">
        <div class="w-20 h-20 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 font-bold text-2xl mx-auto mb-4">
            {{ mb_substr($teacher->name,0,1) }}
        </div>
        <h2 class="text-xl font-bold text-slate-800">{{ $teacher->name }}</h2>
        <p class="text-xs font-mono text-slate-400 mt-1">{{ $teacher->teacher_code }}</p>
        <span class="mt-2 inline-block px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
            {{ $teacher->position==='homeroom' ? 'គ្រូប្រចាំថ្នាក់' : 'គ្រូមុខវិជ្ជា' }}
        </span>
        <div class="mt-4 flex gap-2 justify-center">
            <a href="{{ route('teachers.edit',$teacher) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded-lg">កែប្រែ</a>
        </div>
    </x-card>

    <div class="lg:col-span-2 space-y-5">
        <x-card>
            <div class="p-5">
                <h3 class="font-semibold text-slate-700 mb-4">ព័ត៌មានលម្អិត</h3>
                <dl class="grid grid-cols-2 gap-3 text-sm">
                    <div><dt class="text-slate-400">ភេទ</dt><dd class="font-medium text-slate-700">{{ $teacher->gender==='male' ? 'ប្រុស' : 'ស្រី' }}</dd></div>
                    <div><dt class="text-slate-400">ទូរស័ព្ទ</dt><dd class="font-medium text-slate-700">{{ $teacher->phone ?? '—' }}</dd></div>
                    <div><dt class="text-slate-400">អ៊ីមែល</dt><dd class="font-medium text-slate-700">{{ $teacher->email ?? '—' }}</dd></div>
                    <div><dt class="text-slate-400">ប្រាក់ខែ</dt><dd class="font-medium text-slate-700">{{ number_format($teacher->salary) }}៛</dd></div>
                    <div class="col-span-2"><dt class="text-slate-400">អាសយដ្ឋាន</dt><dd class="font-medium text-slate-700">{{ $teacher->address ?? '—' }}</dd></div>
                </dl>
            </div>
        </x-card>
        <x-card>
            <div class="p-5">
                <h3 class="font-semibold text-slate-700 mb-3">ថ្នាក់ប្រចាំ ({{ $teacher->homeroomClasses->count() }})</h3>
                @forelse($teacher->homeroomClasses as $class)
                    <span class="inline-block px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-xs mr-1 mb-1">{{ $class->name }}</span>
                @empty
                    <p class="text-sm text-slate-400">គ្មាន</p>
                @endforelse
            </div>
        </x-card>
    </div>
</div>
@endsection

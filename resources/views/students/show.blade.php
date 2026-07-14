@extends('layouts.admin')
@section('title','ព័ត៌មានសិស្ស')
@section('page-title','ព័ត៌មានសិស្ស')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Profile card --}}
    <x-card class="p-6 text-center lg:col-span-1">
        <div class="w-24 h-24 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-3xl mx-auto mb-4">
            {{ mb_substr($student->name_kh,0,1) }}
        </div>
        <h2 class="text-xl font-bold text-slate-800">{{ $student->name_kh }}</h2>
        @if($student->name_en)<p class="text-slate-500 text-sm">{{ $student->name_en }}</p>@endif
        <p class="text-xs font-mono text-slate-400 mt-1">{{ $student->student_code }}</p>
        <span class="mt-3 inline-block px-3 py-1 rounded-full text-xs font-medium {{ $student->status==='active' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-600' }}">
            {{ $student->status==='active' ? 'សកម្ម' : 'អសកម្ម' }}
        </span>
        <div class="mt-4 flex gap-2 justify-center">
            <a href="{{ route('students.edit',$student) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded-lg">កែប្រែ</a>
        </div>
    </x-card>

    {{-- Details --}}
    <div class="lg:col-span-2 space-y-5">
        <x-card>
            <div class="p-5">
                <h3 class="font-semibold text-slate-700 mb-4">ព័ត៌មានផ្ទាល់ខ្លួន</h3>
                <dl class="grid grid-cols-2 gap-3 text-sm">
                    <div><dt class="text-slate-400">ភេទ</dt><dd class="font-medium text-slate-700">{{ $student->gender==='male' ? 'ប្រុស' : 'ស្រី' }}</dd></div>
                    <div><dt class="text-slate-400">ថ្ងៃខែឆ្នាំកំណើត</dt><dd class="font-medium text-slate-700">{{ $student->dob?->format('d/m/Y') ?? '—' }}</dd></div>
                    <div><dt class="text-slate-400">ទូរស័ព្ទ</dt><dd class="font-medium text-slate-700">{{ $student->phone ?? '—' }}</dd></div>
                    <div><dt class="text-slate-400">ថ្នាក់រៀន</dt><dd class="font-medium text-slate-700">{{ $student->class?->name ?? '—' }}</dd></div>
                    <div><dt class="text-slate-400">ឪពុក</dt><dd class="font-medium text-slate-700">{{ $student->father_name ?? '—' }}</dd></div>
                    <div><dt class="text-slate-400">ម្ដាយ</dt><dd class="font-medium text-slate-700">{{ $student->mother_name ?? '—' }}</dd></div>
                    <div class="col-span-2"><dt class="text-slate-400">អាសយដ្ឋាន</dt><dd class="font-medium text-slate-700">{{ $student->address ?? '—' }}</dd></div>
                </dl>
            </div>
        </x-card>

        {{-- Recent attendance --}}
        <x-card>
            <div class="p-5">
                <h3 class="font-semibold text-slate-700 mb-3">វត្តមានថ្មីៗ</h3>
                @forelse($student->attendances as $att)
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50 last:border-0 text-sm">
                        <span class="text-slate-600">{{ $att->date->format('d/m/Y') }}</span>
                        <span class="px-2 py-0.5 rounded text-xs font-medium {{ $att->status==='present' ? 'bg-green-100 text-green-700' : ($att->status==='absent' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ match($att->status){ 'present'=>'មានវត្តមាន','absent'=>'អវត្តមាន','late'=>'យឺត',default=>'ច្បាប់' } }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">មិនទាន់មានទិន្នន័យ</p>
                @endforelse
            </div>
        </x-card>
    </div>
</div>
@endsection

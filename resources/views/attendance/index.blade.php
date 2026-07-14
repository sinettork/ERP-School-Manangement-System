@extends('layouts.admin')
@section('title','វត្តមាន')
@section('page-title','កត់ត្រាវត្តមានប្រចាំថ្ងៃ')

@section('content')
<div class="space-y-5">

{{-- Filter --}}
<x-card>
    <form method="GET" class="flex flex-wrap gap-3 p-4 items-end">
        <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">ថ្នាក់រៀន</label>
            <select name="class_id" class="rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                <option value="">-- ជ្រើសថ្នាក់ --</option>
                @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ $classId == $c->id ? 'selected':'' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">ថ្ងៃខែ</label>
            <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()"
                   class="rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"/>
        </div>
        <a href="{{ route('attendance.report') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-700 hover:bg-slate-800 text-white text-sm rounded-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            របាយការណ៍ប្រចាំខែ
        </a>
    </form>
</x-card>

@if($classId && $students->count())
<form method="POST" action="{{ route('attendance.store') }}">
@csrf
<input type="hidden" name="class_id" value="{{ $classId }}"/>
<input type="hidden" name="date"     value="{{ $date }}"/>

<x-card>
    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
        <div>
            <h3 class="font-semibold text-slate-800">
                {{ $classes->firstWhere('id',$classId)?->name }} — {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
            </h3>
            <p class="text-xs text-slate-400 mt-0.5">សិស្សសរុប: {{ $students->count() }}</p>
        </div>
        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
            រក្សាទុក
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600 w-8">#</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ឈ្មោះសិស្ស</th>
                    <th class="px-4 py-3 text-center font-semibold text-green-700">
                        <span class="inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> មានវត្តមាន</span>
                    </th>
                    <th class="px-4 py-3 text-center font-semibold text-red-700">
                        <span class="inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg> អវត្តមាន</span>
                    </th>
                    <th class="px-4 py-3 text-center font-semibold text-yellow-700">
                        <span class="inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> យឺត</span>
                    </th>
                    <th class="px-4 py-3 text-center font-semibold text-blue-700">
                        <span class="inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> ច្បាប់</span>
                    </th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">កំណត់ចំណាំ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($students as $student)
                @php $existing = $attendances->get($student->id); @endphp
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 text-slate-400">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-medium text-slate-800">{{ $student->name_kh }}</td>
                    @foreach(['present','absent','late','leave'] as $status)
                    <td class="px-4 py-3 text-center">
                        <input type="radio"
                               name="statuses[{{ $student->id }}]"
                               value="{{ $status }}"
                               {{ ($existing?->status ?? 'present') === $status ? 'checked':'' }}
                               class="w-4 h-4 {{ $status==='present' ? 'text-green-600' : ($status==='absent' ? 'text-red-600' : ($status==='late' ? 'text-yellow-600' : 'text-blue-600')) }} focus:ring-indigo-500"/>
                    </td>
                    @endforeach
                    <td class="px-4 py-2">
                        <input type="text" name="notes[{{ $student->id }}]"
                               value="{{ $existing?->note }}"
                               placeholder="..."
                               class="w-full rounded border-slate-300 text-xs py-1 focus:border-indigo-500 focus:ring-indigo-500"/>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100 flex justify-end">
        <button type="submit" class="inline-flex items-center gap-1.5 px-6 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
            រក្សាទុក
        </button>
    </div>
</x-card>
</form>
@elseif($classId)
<x-card class="p-10 text-center text-slate-400">
    <p>មិនមានសិស្សសកម្មក្នុងថ្នាក់នេះ</p>
</x-card>
@else
<x-card class="p-10 text-center text-slate-400">
    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
    </svg>
    <p class="font-medium">សូមជ្រើសថ្នាក់រៀន ដើម្បីចូលបំពេញវត្តមាន</p>
</x-card>
@endif
</div>
@endsection

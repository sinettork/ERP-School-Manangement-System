@extends('layouts.admin')
@section('title','របាយការណ៍វត្តមាន')
@section('page-title','របាយការណ៍វត្តមានប្រចាំខែ')

@section('content')
<x-card class="mb-5">
    <form method="GET" class="flex flex-wrap gap-3 p-4 items-end">
        <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">ថ្នាក់រៀន</label>
            <select name="class_id" class="rounded-lg border-slate-300 text-sm" onchange="this.form.submit()">
                <option value="">-- ជ្រើសថ្នាក់ --</option>
                @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ $classId == $c->id ? 'selected':'' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">ខែ</label>
            <input type="month" name="month" value="{{ $month }}" onchange="this.form.submit()"
                   class="rounded-lg border-slate-300 text-sm"/>
        </div>
        <a href="{{ route('attendance.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 text-slate-700 text-sm rounded-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            ត្រឡប់
        </a>
    </form>
</x-card>

@if($classId && $report->count())
@php
    $days = $report->first()['days'];
    $monthLabel = \Carbon\Carbon::parse($month.'-01')->translatedFormat('F Y');
@endphp
<x-card>
    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
        <h3 class="font-semibold text-slate-800">
            {{ $classes->firstWhere('id',$classId)?->name }} — {{ $month }}
        </h3>
        <div class="flex gap-2 text-xs">
            <span class="px-2 py-1 bg-green-100 text-green-700 rounded">P = មានវត្តមាន</span>
            <span class="px-2 py-1 bg-red-100 text-red-700 rounded">A = អវត្តមាន</span>
            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">L = យឺត</span>
            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">E = ច្បាប់</span>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-xs">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-3 py-2 text-left font-semibold text-slate-600 sticky left-0 bg-slate-50 min-w-36">ឈ្មោះ</th>
                    @foreach($days as $day)
                        @php $d = \Carbon\Carbon::parse($day); @endphp
                        <th class="px-1 py-2 text-center font-semibold text-slate-600 min-w-8
                            {{ $d->isWeekend() ? 'bg-slate-100 text-slate-400' : '' }}">
                            {{ $d->format('d') }}<br>
                            <span class="text-slate-400 font-normal">{{ $d->format('D')[0] }}</span>
                        </th>
                    @endforeach
                    <th class="px-2 py-2 text-center font-semibold text-green-700">P</th>
                    <th class="px-2 py-2 text-center font-semibold text-red-700">A</th>
                    <th class="px-2 py-2 text-center font-semibold text-yellow-700">L</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($report as $row)
                @php
                    $presentCount = $row['records']->where('status','present')->count();
                    $absentCount  = $row['records']->where('status','absent')->count();
                    $lateCount    = $row['records']->where('status','late')->count();
                @endphp
                <tr class="hover:bg-slate-50">
                    <td class="px-3 py-2 font-medium text-slate-800 sticky left-0 bg-white">{{ $row['student']->name_kh }}</td>
                    @foreach($row['days'] as $day)
                        @php
                            $rec = $row['records']->get($day);
                            $sym = match($rec?->status) {
                                'present' => ['P','text-green-600 bg-green-50'],
                                'absent'  => ['A','text-red-600 bg-red-50'],
                                'late'    => ['L','text-yellow-600 bg-yellow-50'],
                                'leave'   => ['E','text-blue-600 bg-blue-50'],
                                default   => ['·','text-slate-300'],
                            };
                        @endphp
                        <td class="px-1 py-2 text-center {{ $sym[1] }} font-semibold">{{ $sym[0] }}</td>
                    @endforeach
                    <td class="px-2 py-2 text-center font-bold text-green-700">{{ $presentCount }}</td>
                    <td class="px-2 py-2 text-center font-bold text-red-700">{{ $absentCount }}</td>
                    <td class="px-2 py-2 text-center font-bold text-yellow-700">{{ $lateCount }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-card>
@elseif($classId)
<x-card class="p-10 text-center text-slate-400">មិនមានទិន្នន័យ</x-card>
@else
<x-card class="p-10 text-center text-slate-400">សូមជ្រើសថ្នាក់រៀន</x-card>
@endif
@endsection

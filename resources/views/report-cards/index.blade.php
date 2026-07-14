@extends('layouts.admin')
@section('title','សៀវភៅពិន្ទុ')
@section('page-title','សៀវភៅពិន្ទុ')

@section('content')
<x-card class="mb-4">
    <form method="GET" id="filterForm" class="flex flex-wrap gap-3 p-4 items-end">
        <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">ឆ្នាំសិក្សា</label>
            <select name="academic_year_id" class="rounded-lg border-slate-300 text-sm" onchange="document.getElementById('filterForm').submit()">
                <option value="">-- ទាំងអស់ --</option>
                @foreach($academicYears as $y)
                    <option value="{{ $y->id }}" {{ request('academic_year_id')==$y->id ? 'selected':'' }}>{{ $y->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">ថ្នាក់</label>
            <select name="class_id" class="rounded-lg border-slate-300 text-sm" onchange="document.getElementById('filterForm').submit()">
                <option value="">-- ទាំងអស់ --</option>
                @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ request('class_id')==$c->id ? 'selected':'' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">ឆមាស</label>
            <select name="semester_id" class="rounded-lg border-slate-300 text-sm" onchange="document.getElementById('filterForm').submit()">
                <option value="">-- ទាំងអស់ --</option>
                @foreach($semesters as $sem)
                    <option value="{{ $sem->id }}" {{ request('semester_id')==$sem->id ? 'selected':'' }}>{{ $sem->name }}</option>
                @endforeach
            </select>
        </div>
        <a href="{{ route('report-cards.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm rounded-lg">សម្អាត</a>
    </form>
</x-card>

<x-card>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200"><tr>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">សិស្ស</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">ថ្នាក់</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">ឆមាស</th>
                <th class="px-4 py-3 text-center font-semibold text-slate-600">ពិន្ទុមធ្យម</th>
                <th class="px-4 py-3 text-center font-semibold text-slate-600">លំដាប់</th>
                <th class="px-4 py-3 text-center font-semibold text-slate-600">អវត្តមាន</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">សកម្មភាព</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($reportCards as $rc)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">
                        <p class="font-medium text-slate-800">{{ $rc->student->name_kh }}</p>
                        <p class="text-xs text-slate-400">{{ $rc->student->student_code }}</p>
                    </td>
                    <td class="px-4 py-3 text-slate-600">{{ $rc->class->name }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $rc->semester->name }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="font-bold text-lg {{ $rc->average_score >= 60 ? 'text-green-700' : 'text-red-600' }}">
                            {{ number_format($rc->average_score, 1) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center font-semibold text-indigo-700">{{ $rc->rank ?? '—' }}</td>
                    <td class="px-4 py-3 text-center text-slate-600">{{ $rc->total_absent }}</td>
                    <td class="px-4 py-3">
                        <x-table-actions
                            :showRoute="route('report-cards.show',$rc)"
                            :deleteRoute="route('report-cards.destroy',$rc)"
                        />
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-10 text-center text-slate-400">មិនទាន់មានទិន្នន័យ</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($reportCards->hasPages())
    <div class="px-4 py-3 border-t border-slate-100">{{ $reportCards->links() }}</div>
    @endif
</x-card>
@endsection

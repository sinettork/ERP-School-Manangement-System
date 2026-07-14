@extends('layouts.admin')
@section('title','ការប្រឡង')
@section('page-title','គ្រប់គ្រងការប្រឡង')

@section('content')
<x-page-header title="ការប្រឡងទាំងអស់" :createRoute="route('exams.create')" createLabel="បន្ថែមការប្រឡង"/>

<x-card class="mb-4">
    <form method="GET" class="flex flex-wrap gap-3 p-4">
        <select name="academic_year_id" class="rounded-lg border-slate-300 text-sm" onchange="this.form.submit()">
            <option value="">-- ឆ្នាំសិក្សា --</option>
            @foreach($academicYears as $y)
                <option value="{{ $y->id }}" {{ request('academic_year_id')==$y->id ? 'selected':'' }}>{{ $y->name }}</option>
            @endforeach
        </select>
        <a href="{{ route('exams.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm rounded-lg">សម្អាត</a>
        <a href="{{ route('scores.index') }}" class="ml-auto px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-sm font-medium rounded-lg">
            ✏️ បញ្ចូលពិន្ទុ
        </a>
    </form>
</x-card>

<x-card>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">#</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ឈ្មោះ</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ប្រភេទ</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ឆ្មាស</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ចាប់ផ្ដើម</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">បញ្ចប់</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">សកម្មភាព</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($exams as $exam)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 text-slate-500">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-medium text-slate-800">{{ $exam->name }}</td>
                    <td class="px-4 py-3">
                        @php $tc = match($exam->exam_type){ 'monthly'=>'bg-blue-100 text-blue-700','midterm'=>'bg-yellow-100 text-yellow-700',default=>'bg-red-100 text-red-700' }; @endphp
                        <span class="px-2 py-0.5 rounded text-xs font-medium {{ $tc }}">
                            {{ match($exam->exam_type){ 'monthly'=>'ប្រចាំខែ','midterm'=>'មធ្យមភាគ',default=>'ចុងឆមាស' } }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-slate-600">{{ $exam->semester?->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $exam->start_date?->format('d/m/Y') ?? '—' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $exam->end_date?->format('d/m/Y') ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <x-table-actions :editRoute="route('exams.edit',$exam)" :deleteRoute="route('exams.destroy',$exam)"/>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-10 text-center text-slate-400">មិនទាន់មានទិន្នន័យ</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($exams->hasPages())
    <div class="px-4 py-3 border-t border-slate-100">{{ $exams->links() }}</div>
    @endif
</x-card>
@endsection

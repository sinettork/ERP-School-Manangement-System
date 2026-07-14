@extends('layouts.admin')
@section('title','បញ្ចូលពិន្ទុ')
@section('page-title','បញ្ចូលពិន្ទុ')

@section('content')
<x-card class="mb-5">
    <form method="GET" id="filterForm" class="flex flex-wrap gap-3 p-4 items-end">
        <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">ការប្រឡង <span class="text-red-500">*</span></label>
            <select name="exam_id" required class="rounded-lg border-slate-300 text-sm focus:border-indigo-500" onchange="document.getElementById('filterForm').submit()">
                <option value="">-- ជ្រើស --</option>
                @foreach($exams as $exam)
                    <option value="{{ $exam->id }}" {{ $examId==$exam->id ? 'selected':'' }}>
                        {{ $exam->name }} ({{ $exam->academicYear->name }})
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">ថ្នាក់រៀន <span class="text-red-500">*</span></label>
            <select name="class_id" required class="rounded-lg border-slate-300 text-sm focus:border-indigo-500" onchange="document.getElementById('filterForm').submit()">
                <option value="">-- ជ្រើស --</option>
                @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ $classId==$c->id ? 'selected':'' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
    </form>
</x-card>

@if($examId && $classId && $students->count())
<form method="POST" action="{{ route('scores.store') }}">
@csrf
<input type="hidden" name="exam_id"  value="{{ $examId }}"/>
<input type="hidden" name="class_id" value="{{ $classId }}"/>

<x-card class="mb-4">
    <div class="p-4 flex flex-wrap gap-3 items-end border-b border-slate-100">
        <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">មុខវិជ្ជា <span class="text-red-500">*</span></label>
            <select name="subject_id" required class="rounded-lg border-slate-300 text-sm focus:border-indigo-500">
                <option value="">-- ជ្រើស --</option>
                @foreach($subjects as $subj)
                    <option value="{{ $subj->id }}">{{ $subj->name_kh }}</option>
                @endforeach
            </select>
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
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">#</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ឈ្មោះសិស្ស</th>
                    <th class="px-4 py-3 text-center font-semibold text-slate-600">ការងារផ្ទះ<br><span class="text-xs font-normal text-slate-400">(/ ១០)</span></th>
                    <th class="px-4 py-3 text-center font-semibold text-slate-600">ក្នុងថ្នាក់<br><span class="text-xs font-normal text-slate-400">(/ ២០)</span></th>
                    <th class="px-4 py-3 text-center font-semibold text-slate-600">ប្រឡង<br><span class="text-xs font-normal text-slate-400">(/ ៧០)</span></th>
                    <th class="px-4 py-3 text-center font-semibold text-slate-600">សរុប</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100" id="scoreBody">
                @foreach($students as $student)
                @php $key = $student->id . '_'; @endphp
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-2 text-slate-400 text-xs">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 font-medium text-slate-800">{{ $student->name_kh }}</td>
                    @foreach(['homework_score','classwork_score','exam_score'] as $field)
                    <td class="px-2 py-2 text-center">
                        <input type="number" name="scores[{{ $student->id }}][{{ $field }}]"
                               min="0" max="{{ $field==='homework_score' ? 10 : ($field==='classwork_score' ? 20 : 70) }}"
                               step="0.5"
                               value="{{ old("scores.{$student->id}.{$field}", 0) }}"
                               class="w-16 text-center rounded-lg border-slate-300 text-sm focus:border-indigo-500 score-input"
                               data-row="{{ $student->id }}"/>
                    </td>
                    @endforeach
                    <td class="px-4 py-2 text-center font-bold text-indigo-700" id="total_{{ $student->id }}">0</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-card>
</form>

<script>
document.querySelectorAll('.score-input').forEach(input => {
    input.addEventListener('input', () => {
        const row = input.dataset.row;
        const inputs = document.querySelectorAll(`.score-input[data-row="${row}"]`);
        let total = 0;
        inputs.forEach(i => total += parseFloat(i.value) || 0);
        const cell = document.getElementById('total_' + row);
        if (cell) {
            cell.textContent = total.toFixed(1);
            cell.className = 'px-4 py-2 text-center font-bold ' + (total >= 60 ? 'text-green-600' : 'text-red-600');
        }
    });
});
</script>

@elseif($examId && $classId)
<x-card class="p-10 text-center text-slate-400">មិនមានសិស្សសកម្ម</x-card>
@else
<x-card class="p-10 text-center text-slate-400">
    <p class="font-medium">សូមជ្រើសការប្រឡង និង ថ្នាក់រៀន</p>
</x-card>
@endif
@endsection

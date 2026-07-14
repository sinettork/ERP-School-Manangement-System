@extends('layouts.admin')
@section('title','សៀវភៅពិន្ទុ')
@section('page-title','សៀវភៅពិន្ទុ')

@section('content')
<div class="max-w-2xl mx-auto">
    <x-card>
        <div class="p-6">
            <div class="text-center mb-6 pb-4 border-b border-slate-100">
                <p class="text-xs text-slate-400">{{ $reportCard->academicYear->name }} — {{ $reportCard->semester->name }}</p>
                <h2 class="text-xl font-bold text-slate-800 mt-1">{{ $reportCard->student->name_kh }}</h2>
                <p class="text-sm text-slate-500">{{ $reportCard->class->name }}</p>
            </div>
            <div class="grid grid-cols-3 gap-4 text-center mb-6">
                <div class="bg-indigo-50 rounded-xl p-4">
                    <p class="text-xs text-slate-500 mb-1">ពិន្ទុមធ្យម</p>
                    <p class="text-3xl font-bold {{ $reportCard->average_score >= 60 ? 'text-green-700' : 'text-red-600' }}">
                        {{ number_format($reportCard->average_score, 1) }}
                    </p>
                </div>
                <div class="bg-indigo-50 rounded-xl p-4">
                    <p class="text-xs text-slate-500 mb-1">លំដាប់</p>
                    <p class="text-3xl font-bold text-indigo-700">{{ $reportCard->rank ?? '—' }}</p>
                </div>
                <div class="bg-indigo-50 rounded-xl p-4">
                    <p class="text-xs text-slate-500 mb-1">ថ្ងៃអវត្តមាន</p>
                    <p class="text-3xl font-bold text-slate-700">{{ $reportCard->total_absent }}</p>
                </div>
            </div>
            @if($reportCard->scores->count())
            <h3 class="font-semibold text-slate-700 mb-3">ពិន្ទុរៀងរាល់មុខវិជ្ជា</h3>
            <table class="w-full text-sm">
                <thead class="bg-slate-50"><tr>
                    <th class="px-3 py-2 text-left font-semibold text-slate-600">មុខវិជ្ជា</th>
                    <th class="px-3 py-2 text-center font-semibold text-slate-600">ផ្ទះ</th>
                    <th class="px-3 py-2 text-center font-semibold text-slate-600">ថ្នាក់</th>
                    <th class="px-3 py-2 text-center font-semibold text-slate-600">ប្រឡង</th>
                    <th class="px-3 py-2 text-center font-semibold text-slate-600">សរុប</th>
                    <th class="px-3 py-2 text-center font-semibold text-slate-600">ថ្នាក់</th>
                </tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($reportCard->scores as $score)
                    <tr>
                        <td class="px-3 py-2 text-slate-700">{{ $score->subject->name_kh }}</td>
                        <td class="px-3 py-2 text-center text-slate-600">{{ $score->homework_score }}</td>
                        <td class="px-3 py-2 text-center text-slate-600">{{ $score->classwork_score }}</td>
                        <td class="px-3 py-2 text-center text-slate-600">{{ $score->exam_score }}</td>
                        <td class="px-3 py-2 text-center font-bold {{ $score->total_score >= 60 ? 'text-green-700' : 'text-red-600' }}">{{ $score->total_score }}</td>
                        <td class="px-3 py-2 text-center font-bold">{{ $score->grade }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </x-card>
    <div class="flex gap-3 mt-4">
        <a href="{{ route('report-cards.index') }}" class="px-5 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg">ត្រឡប់</a>
    </div>
</div>
@endsection

@extends('layouts.admin')
@section('title','ឆ្នាំសិក្សា')
@section('page-title','ឆ្នាំសិក្សា')

@section('content')
<x-page-header title="ឆ្នាំសិក្សាទាំងអស់" :createRoute="route('academic-years.create')" createLabel="បន្ថែមឆ្នាំសិក្សា"/>

<x-card>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">#</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ឆ្នាំសិក្សា</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ចាប់ផ្ដើម</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">បញ្ចប់</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ថ្នាក់</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">សិស្ស</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ស្ថានភាព</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">សកម្មភាព</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($academicYears as $year)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 text-slate-500">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-semibold text-slate-800">{{ $year->name }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $year->start_date->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $year->end_date->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $year->classes_count }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $year->students_count }}</td>
                    <td class="px-4 py-3">
                        @if($year->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">សកម្ម</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">អសកម្ម</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <x-table-actions
                            :editRoute="route('academic-years.edit',$year)"
                            :deleteRoute="route('academic-years.destroy',$year)"
                        />
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-4 py-10 text-center text-slate-400">មិនទាន់មានទិន្នន័យ</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>
@endsection

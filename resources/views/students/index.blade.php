@extends('layouts.admin')
@section('title','សិស្ស')
@section('page-title','គ្រប់គ្រងសិស្ស')

@section('content')
<x-page-header title="សិស្សទាំងអស់" :createRoute="route('students.create')" createLabel="បន្ថែមសិស្ស"/>

{{-- Filters --}}
<x-card class="mb-4">
    <form method="GET" class="flex flex-wrap gap-3 p-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="ស្វែងរកតាមឈ្មោះ ឬ លេខកូដ..."
               class="flex-1 min-w-48 rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"/>
        <select name="class_id" class="rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">-- ថ្នាក់ --</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
            @endforeach
        </select>
        <select name="status" class="rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">-- ស្ថានភាព --</option>
            <option value="active"    {{ request('status')=='active'    ? 'selected' : '' }}>សកម្ម</option>
            <option value="inactive"  {{ request('status')=='inactive'  ? 'selected' : '' }}>អសកម្ម</option>
            <option value="graduated" {{ request('status')=='graduated' ? 'selected' : '' }}>បានបញ្ចប់</option>
            <option value="dropped"   {{ request('status')=='dropped'   ? 'selected' : '' }}>បោះបង់</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg">ស្វែងរក</button>
        <a href="{{ route('students.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm rounded-lg">សម្អាត</a>
    </form>
</x-card>

<x-card>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">លេខកូដ</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ឈ្មោះ</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ភេទ</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ថ្នាក់</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ទូរស័ព្ទ</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ស្ថានភាព</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">សកម្មភាព</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($students as $student)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 font-mono text-slate-600 text-xs">{{ $student->student_code }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs flex-shrink-0">
                                {{ mb_substr($student->name_kh, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-medium text-slate-800">{{ $student->name_kh }}</p>
                                @if($student->name_en)<p class="text-xs text-slate-400">{{ $student->name_en }}</p>@endif
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-slate-600">{{ $student->gender === 'male' ? 'ប្រុស' : 'ស្រី' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $student->class?->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $student->phone ?? '—' }}</td>
                    <td class="px-4 py-3">
                        @php
                            $statusClass = match($student->status) {
                                'active'    => 'bg-green-100 text-green-800',
                                'graduated' => 'bg-blue-100 text-blue-800',
                                'dropped'   => 'bg-red-100 text-red-800',
                                default     => 'bg-slate-100 text-slate-600',
                            };
                            $statusLabel = match($student->status) {
                                'active'    => 'សកម្ម',
                                'inactive'  => 'អសកម្ម',
                                'graduated' => 'បញ្ចប់ការសិក្សា',
                                'dropped'   => 'បោះបង់',
                                default     => $student->status,
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">{{ $statusLabel }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <x-table-actions
                            :showRoute="route('students.show',$student)"
                            :editRoute="route('students.edit',$student)"
                            :deleteRoute="route('students.destroy',$student)"
                        />
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-10 text-center text-slate-400">មិនទាន់មានទិន្នន័យ</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($students->hasPages())
    <div class="px-4 py-3 border-t border-slate-100">{{ $students->links() }}</div>
    @endif
</x-card>
@endsection

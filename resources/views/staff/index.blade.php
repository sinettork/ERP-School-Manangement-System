@extends('layouts.admin')
@section('title','បុគ្គលិក')
@section('page-title','គ្រប់គ្រងបុគ្គលិក')

@section('content')
<x-page-header title="បុគ្គលិកទាំងអស់" :createRoute="route('staff.create')" createLabel="បន្ថែមបុគ្គលិក"/>

<x-card class="mb-4">
    <form method="GET" class="flex gap-3 p-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="ស្វែងរក..."
               class="flex-1 rounded-lg border-slate-300 text-sm"/>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg">ស្វែងរក</button>
        <a href="{{ route('staff.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm rounded-lg">សម្អាត</a>
    </form>
</x-card>

<x-card>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200"><tr>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">លេខកូដ</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">ឈ្មោះ</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">មុខតំណែង</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">ទូរស័ព្ទ</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">ប្រាក់ខែ</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">សកម្មភាព</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($staff as $s)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 font-mono text-xs text-slate-500">{{ $s->staff_code }}</td>
                    <td class="px-4 py-3 font-medium text-slate-800">{{ $s->name }}</td>
                    <td class="px-4 py-3 text-slate-600 text-xs">
                        {{ match($s->position){ 'office'=>'ការិយាល័យ','cleaner'=>'អ្នកសំអាត','security'=>'សន្តិសុខ',default=>'ផ្សេង' } }}
                    </td>
                    <td class="px-4 py-3 text-slate-600">{{ $s->phone ?? '—' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ number_format($s->salary) }} ៛</td>
                    <td class="px-4 py-3">
                        <x-table-actions :editRoute="route('staff.edit',$s)" :deleteRoute="route('staff.destroy',$s)"/>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-10 text-center text-slate-400">មិនទាន់មានទិន្នន័យ</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($staff->hasPages())
    <div class="px-4 py-3 border-t border-slate-100">{{ $staff->links() }}</div>
    @endif
</x-card>
@endsection

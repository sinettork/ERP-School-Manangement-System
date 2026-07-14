@extends('layouts.admin')
@section('title','មុខវិជ្ជា')
@section('page-title','គ្រប់គ្រងមុខវិជ្ជា')

@section('content')
<x-page-header title="មុខវិជ្ជាទាំងអស់" :createRoute="route('subjects.create')" createLabel="បន្ថែមមុខវិជ្ជា"/>

<x-card class="mb-4">
    <form method="GET" class="flex gap-3 p-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="ស្វែងរក..."
               class="flex-1 rounded-lg border-slate-300 text-sm"/>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg">ស្វែងរក</button>
        <a href="{{ route('subjects.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm rounded-lg">សម្អាត</a>
    </form>
</x-card>

<x-card>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">#</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">លេខកូដ</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ឈ្មោះ (ខ្មែរ)</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ឈ្មោះ (អង់គ្លេស)</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">សកម្មភាព</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($subjects as $subject)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 text-slate-500">{{ $subjects->firstItem() + $loop->index }}</td>
                    <td class="px-4 py-3 font-mono text-xs text-slate-600 font-semibold">{{ $subject->code }}</td>
                    <td class="px-4 py-3 font-medium text-slate-800">{{ $subject->name_kh }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $subject->name_en }}</td>
                    <td class="px-4 py-3">
                        <x-table-actions
                            :editRoute="route('subjects.edit',$subject)"
                            :deleteRoute="route('subjects.destroy',$subject)"
                        />
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-10 text-center text-slate-400">មិនទាន់មានទិន្នន័យ</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($subjects->hasPages())
    <div class="px-4 py-3 border-t border-slate-100">{{ $subjects->links() }}</div>
    @endif
</x-card>
@endsection

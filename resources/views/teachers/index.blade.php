@extends('layouts.admin')
@section('title','គ្រូបង្រៀន')
@section('page-title','គ្រប់គ្រងគ្រូបង្រៀន')

@section('content')
<x-page-header title="គ្រូបង្រៀនទាំងអស់" :createRoute="route('teachers.create')" createLabel="បន្ថែមគ្រូ"/>

<x-card class="mb-4">
    <form method="GET" class="flex flex-wrap gap-3 p-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="ស្វែងរកតាមឈ្មោះ ឬ លេខកូដ..."
               class="flex-1 min-w-48 rounded-lg border-slate-300 text-sm"/>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg">ស្វែងរក</button>
        <a href="{{ route('teachers.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm rounded-lg">សម្អាត</a>
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
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">មុខតំណែង</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ទូរស័ព្ទ</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ប្រាក់ខែ</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">សកម្មភាព</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($teachers as $teacher)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 font-mono text-slate-600 text-xs">{{ $teacher->teacher_code }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 font-bold text-xs flex-shrink-0">
                                {{ mb_substr($teacher->name,0,1) }}
                            </div>
                            <p class="font-medium text-slate-800">{{ $teacher->name }}</p>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-slate-600">{{ $teacher->gender === 'male' ? 'ប្រុស' : 'ស្រី' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded text-xs font-medium {{ $teacher->position==='homeroom' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $teacher->position==='homeroom' ? 'គ្រូប្រចាំថ្នាក់' : 'គ្រូមុខវិជ្ជា' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-slate-600">{{ $teacher->phone ?? '—' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ number_format($teacher->salary) }}៛</td>
                    <td class="px-4 py-3">
                        <x-table-actions
                            :showRoute="route('teachers.show',$teacher)"
                            :editRoute="route('teachers.edit',$teacher)"
                            :deleteRoute="route('teachers.destroy',$teacher)"
                        />
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-10 text-center text-slate-400">មិនទាន់មានទិន្នន័យ</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($teachers->hasPages())
    <div class="px-4 py-3 border-t border-slate-100">{{ $teachers->links() }}</div>
    @endif
</x-card>
@endsection

@extends('layouts.admin')
@section('title','ថ្នាក់រៀន')
@section('page-title','គ្រប់គ្រងថ្នាក់រៀន')

@section('content')
<x-page-header title="ថ្នាក់រៀនទាំងអស់" :createRoute="route('classes.create')" createLabel="បន្ថែមថ្នាក់"/>

<x-card class="mb-4">
    <form method="GET" class="flex flex-wrap gap-3 p-4">
        <select name="academic_year_id" class="rounded-lg border-slate-300 text-sm">
            <option value="">-- ឆ្នាំសិក្សា --</option>
            @foreach($academicYears as $y)
                <option value="{{ $y->id }}" {{ request('academic_year_id')==$y->id ? 'selected':'' }}>{{ $y->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg">ត្រង</button>
        <a href="{{ route('classes.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm rounded-lg">សម្អាត</a>
    </form>
</x-card>

<x-card>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ឈ្មោះថ្នាក់</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ថ្នាក់ទី</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">វេន</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">គ្រូប្រចាំថ្នាក់</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">សិស្ស</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ឆ្នាំសិក្សា</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">សកម្មភាព</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($classes as $class)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 font-semibold text-slate-800">{{ $class->name }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $class->grade_level }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded text-xs font-medium {{ $class->shift==='morning' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $class->shift==='morning' ? 'ព្រឹក' : 'រសៀល' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-slate-600">{{ $class->homeroomTeacher?->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $class->students->count() }} / {{ $class->max_students }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $class->academicYear?->name ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <x-table-actions
                            :showRoute="route('classes.show',$class)"
                            :editRoute="route('classes.edit',$class)"
                            :deleteRoute="route('classes.destroy',$class)"
                        />
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-10 text-center text-slate-400">មិនទាន់មានទិន្នន័យ</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($classes->hasPages())
    <div class="px-4 py-3 border-t border-slate-100">{{ $classes->links() }}</div>
    @endif
</x-card>
@endsection

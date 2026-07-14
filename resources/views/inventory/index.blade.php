@extends('layouts.admin')
@section('title','សម្ភារៈ')
@section('page-title','គ្រប់គ្រងសម្ភារៈ')

@section('content')
<x-page-header title="សម្ភារៈទាំងអស់" :createRoute="route('inventory.create')" createLabel="បន្ថែមសម្ភារៈ"/>

<x-card class="mb-4">
    <form method="GET" class="flex gap-3 p-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="ស្វែងរក..."
               class="flex-1 rounded-lg border-slate-300 text-sm"/>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg">ស្វែងរក</button>
        <a href="{{ route('inventory.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm rounded-lg">សម្អាត</a>
    </form>
</x-card>

<x-card>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200"><tr>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">ឈ្មោះ</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">ប្រភេទ</th>
                <th class="px-4 py-3 text-center font-semibold text-slate-600">ចំនួន</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">ស្ថានភាព</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">ទីតាំង</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">ថ្ងៃទិញ</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">សកម្មភាព</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($items as $item)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 font-medium text-slate-800">{{ $item->name }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $item->category ?? '—' }}</td>
                    <td class="px-4 py-3 text-center font-semibold text-slate-700">{{ $item->quantity }}</td>
                    <td class="px-4 py-3">
                        @php $cc = match($item->condition){ 'good'=>'bg-green-100 text-green-700','fair'=>'bg-yellow-100 text-yellow-700','poor'=>'bg-orange-100 text-orange-700',default=>'bg-red-100 text-red-700' }; @endphp
                        <span class="px-2 py-0.5 rounded text-xs font-medium {{ $cc }}">
                            {{ match($item->condition){ 'good'=>'ល្អ','fair'=>'មធ្យម','poor'=>'ខ្សោយ',default=>'ខូច' } }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-slate-600">{{ $item->location ?? '—' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $item->purchased_date?->format('d/m/Y') ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <x-table-actions :editRoute="route('inventory.edit',$item)" :deleteRoute="route('inventory.destroy',$item)"/>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-10 text-center text-slate-400">មិនទាន់មានទិន្នន័យ</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($items->hasPages())
    <div class="px-4 py-3 border-t border-slate-100">{{ $items->links() }}</div>
    @endif
</x-card>
@endsection

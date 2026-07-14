@extends('layouts.admin')
@section('title','បណ្ណាល័យ')
@section('page-title','គ្រប់គ្រងបណ្ណាល័យ')

@section('content')
<x-page-header title="សៀវភៅទាំងអស់" :createRoute="route('library.create')" createLabel="បន្ថែមសៀវភៅ"/>

<x-card class="mb-4">
    <form method="GET" class="flex gap-3 p-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="ស្វែងរកតាមចំណងជើង ឬ អ្នកនិពន្ធ..."
               class="flex-1 rounded-lg border-slate-300 text-sm"/>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg">ស្វែងរក</button>
        <a href="{{ route('library.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm rounded-lg">សម្អាត</a>
    </form>
</x-card>

<x-card>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200"><tr>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">ចំណងជើង</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">អ្នកនិពន្ធ</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">ប្រភេទ</th>
                <th class="px-4 py-3 text-center font-semibold text-slate-600">ចំនួន</th>
                <th class="px-4 py-3 text-center font-semibold text-slate-600">អាចខ្ចី</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">ទីតាំង</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">សកម្មភាព</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($books as $book)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">
                        <p class="font-medium text-slate-800">{{ $book->title }}</p>
                        @if($book->isbn)<p class="text-xs text-slate-400">ISBN: {{ $book->isbn }}</p>@endif
                    </td>
                    <td class="px-4 py-3 text-slate-600">{{ $book->author ?? '—' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $book->category ?? '—' }}</td>
                    <td class="px-4 py-3 text-center text-slate-700">{{ $book->quantity }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="font-semibold {{ $book->available_quantity > 0 ? 'text-green-700' : 'text-red-600' }}">
                            {{ $book->available_quantity }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-slate-600 text-xs">{{ $book->shelf_location ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <x-table-actions :editRoute="route('library.edit',$book)" :deleteRoute="route('library.destroy',$book)"/>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-10 text-center text-slate-400">មិនទាន់មានទិន្នន័យ</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($books->hasPages())
    <div class="px-4 py-3 border-t border-slate-100">{{ $books->links() }}</div>
    @endif
</x-card>
@endsection

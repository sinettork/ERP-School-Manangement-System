@extends('layouts.admin')
@section('title','អ្នកប្រើប្រាស់')
@section('page-title','គ្រប់គ្រងអ្នកប្រើប្រាស់')

@section('content')
<x-page-header title="អ្នកប្រើប្រាស់ទាំងអស់" :createRoute="route('users.create')" createLabel="បន្ថែមអ្នកប្រើប្រាស់"/>

<x-card class="mb-4">
    <form method="GET" class="flex flex-wrap gap-3 p-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="ស្វែងរកតាមឈ្មោះ ឬ អ៊ីមែល..."
               class="flex-1 min-w-48 rounded-lg border-slate-300 text-sm"/>
        <select name="role" class="rounded-lg border-slate-300 text-sm" onchange="this.form.submit()">
            <option value="">-- តួនាទី --</option>
            @foreach($roles as $r)
                <option value="{{ $r->name }}" {{ request('role')==$r->name ? 'selected':'' }}>{{ $r->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg">ស្វែងរក</button>
        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm rounded-lg">សម្អាត</a>
    </form>
</x-card>

<x-card>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200"><tr>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">ឈ្មោះ</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">អ៊ីមែល</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">ទូរស័ព្ទ</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">តួនាទី</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">ស្ថានភាព</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">សកម្មភាព</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $u)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs flex-shrink-0">
                                {{ strtoupper(substr($u->name,0,1)) }}
                            </div>
                            <p class="font-medium text-slate-800">{{ $u->name }}</p>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-slate-600">{{ $u->email }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $u->phone ?? '—' }}</td>
                    <td class="px-4 py-3">
                        @foreach($u->roles as $role)
                        <span class="px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-700 mr-1">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $u->status==='active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $u->status==='active' ? 'សកម្ម' : 'អសកម្ម' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <x-table-actions
                            :editRoute="route('users.edit',$u)"
                            :deleteRoute="$u->id !== auth()->id() ? route('users.destroy',$u) : null"
                        />
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-10 text-center text-slate-400">មិនទាន់មានទិន្នន័យ</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-4 py-3 border-t border-slate-100">{{ $users->links() }}</div>
    @endif
</x-card>
@endsection

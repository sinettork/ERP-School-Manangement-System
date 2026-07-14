@extends('layouts.admin')
@section('title','សេចក្ដីជូនដំណឹង')
@section('page-title','គ្រប់គ្រងសេចក្ដីជូនដំណឹង')

@section('content')
<x-page-header title="សេចក្ដីជូនដំណឹង" :createRoute="route('announcements.create')" createLabel="បន្ថែមថ្មី"/>

<x-card class="mb-4">
    <form method="GET" class="flex flex-wrap gap-3 p-4">
        <select name="target_role" class="rounded-lg border-slate-300 text-sm" onchange="this.form.submit()">
            <option value="">-- ប្រភេទ --</option>
            <option value="all"     {{ request('target_role')=='all'     ? 'selected':'' }}>ទាំងអស់</option>
            <option value="teacher" {{ request('target_role')=='teacher' ? 'selected':'' }}>គ្រូ</option>
            <option value="student" {{ request('target_role')=='student' ? 'selected':'' }}>សិស្ស</option>
            <option value="parent"  {{ request('target_role')=='parent'  ? 'selected':'' }}>អាណាព្យាបាល</option>
        </select>
        <a href="{{ route('announcements.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm rounded-lg">សម្អាត</a>
    </form>
</x-card>

<div class="space-y-3">
    @forelse($announcements as $ann)
    <x-card>
        <div class="p-5 flex items-start justify-between gap-4">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-1">
                    @php $rc = match($ann->target_role){ 'all'=>'bg-slate-100 text-slate-700','teacher'=>'bg-purple-100 text-purple-700','student'=>'bg-blue-100 text-blue-700',default=>'bg-green-100 text-green-700' }; @endphp
                    <span class="px-2 py-0.5 rounded text-xs font-medium {{ $rc }}">
                        {{ match($ann->target_role){ 'all'=>'ទាំងអស់','teacher'=>'គ្រូ','student'=>'សិស្ស',default=>'អាណាព្យាបាល' } }}
                    </span>
                    <span class="text-xs text-slate-400">{{ $ann->created_at->diffForHumans() }}</span>
                </div>
                <h3 class="font-semibold text-slate-800 text-base">{{ $ann->title }}</h3>
                <p class="text-sm text-slate-500 mt-1 line-clamp-2">{{ $ann->content }}</p>
                <p class="text-xs text-slate-400 mt-2">ដោយ: {{ $ann->postedBy?->name ?? '—' }}</p>
            </div>
            <div class="flex items-center gap-1 flex-shrink-0">
                <a href="{{ route('announcements.show',$ann) }}" class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </a>
                <a href="{{ route('announcements.edit',$ann) }}" class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </a>
                <form method="POST" action="{{ route('announcements.destroy',$ann) }}" onsubmit="return confirm('លុបទិន្នន័យ?')">
                    @csrf @method('DELETE')
                    <button class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </x-card>
    @empty
    <x-card class="p-10 text-center text-slate-400">មិនទាន់មានសេចក្ដីជូនដំណឹង</x-card>
    @endforelse
</div>
@if($announcements->hasPages())
<div class="mt-4">{{ $announcements->links() }}</div>
@endif
@endsection

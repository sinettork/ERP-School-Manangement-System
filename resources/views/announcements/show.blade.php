@extends('layouts.admin')
@section('title','សេចក្ដីជូនដំណឹង')
@section('page-title','សេចក្ដីជូនដំណឹង')

@section('content')
<div class="max-w-2xl mx-auto">
    <x-card>
        <div class="p-6">
            <div class="flex items-center gap-2 mb-3">
                @php $rc = match($announcement->target_role){ 'all'=>'bg-slate-100 text-slate-700','teacher'=>'bg-purple-100 text-purple-700','student'=>'bg-blue-100 text-blue-700',default=>'bg-green-100 text-green-700' }; @endphp
                <span class="px-2 py-0.5 rounded text-xs font-medium {{ $rc }}">
                    {{ match($announcement->target_role){ 'all'=>'ទាំងអស់','teacher'=>'គ្រូ','student'=>'សិស្ស',default=>'អាណាព្យាបាល' } }}
                </span>
                <span class="text-xs text-slate-400">{{ $announcement->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <h2 class="text-xl font-bold text-slate-800 mb-4">{{ $announcement->title }}</h2>
            <div class="prose prose-sm text-slate-700 whitespace-pre-wrap">{{ $announcement->content }}</div>
            <p class="text-xs text-slate-400 mt-4">ដោយ: {{ $announcement->postedBy?->name ?? '—' }}</p>
        </div>
    </x-card>
    <div class="flex gap-3 mt-4">
        <a href="{{ route('announcements.edit',$announcement) }}" class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg">កែប្រែ</a>
        <a href="{{ route('announcements.index') }}" class="px-5 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg">ត្រឡប់</a>
    </div>
</div>
@endsection

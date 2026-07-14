@extends('layouts.admin')

@section('title', 'ផ្ទាំងគ្រប់គ្រង')
@section('page-title', 'ផ្ទាំងគ្រប់គ្រង')

@section('content')
<div class="space-y-6">

    {{-- Stats grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        {{-- Students --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-500">សិស្សទាំងអស់</p>
                <p class="text-2xl font-bold text-slate-800">{{ $stats['students'] }}</p>
                <p class="text-xs text-green-600 mt-0.5">សកម្ម: {{ $stats['active_students'] }}</p>
            </div>
        </div>

        {{-- Teachers --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-500">គ្រូបង្រៀន</p>
                <p class="text-2xl font-bold text-slate-800">{{ $stats['teachers'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">នៅក្នុងប្រព័ន្ធ</p>
            </div>
        </div>

        {{-- Classes --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-500">ថ្នាក់រៀន</p>
                <p class="text-2xl font-bold text-slate-800">{{ $stats['classes'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">{{ $stats['academic_year'] }}</p>
            </div>
        </div>

        {{-- Payments today --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-500">ការទូទាត់ថ្ងៃនេះ</p>
                <p class="text-2xl font-bold text-slate-800">{{ $stats['payments_today'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">ការទូទាត់</p>
            </div>
        </div>

    </div>

    {{-- Second row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Recent announcements --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h2 class="font-semibold text-slate-800">សេចក្ដីជូនដំណឹងថ្មីៗ</h2>
                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">មើលទាំងអស់</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($announcements as $announcement)
                    <div class="px-6 py-4">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-slate-800 truncate">{{ $announcement->title }}</p>
                                <p class="text-sm text-slate-500 mt-0.5 line-clamp-1">{{ Str::limit($announcement->content, 80) }}</p>
                            </div>
                            <div class="flex-shrink-0 text-right">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                    {{ $announcement->target_role === 'all' ? 'bg-slate-100 text-slate-600' :
                                       ($announcement->target_role === 'teacher' ? 'bg-purple-100 text-purple-700' :
                                       ($announcement->target_role === 'student' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700')) }}">
                                    {{ match($announcement->target_role) {
                                        'all'     => 'ទាំងអស់',
                                        'teacher' => 'គ្រូ',
                                        'student' => 'សិស្ស',
                                        'parent'  => 'អាណាព្យាបាល',
                                        default   => $announcement->target_role,
                                    } }}
                                </span>
                                <p class="text-xs text-slate-400 mt-1">
                                    {{ $announcement->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-slate-400">
                        <p class="text-sm">មិនទាន់មានសេចក្ដីជូនដំណឹង</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Quick stats sidebar --}}
        <div class="space-y-5">

            {{-- Attendance today --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                <h2 class="font-semibold text-slate-800 mb-4">វត្តមានថ្ងៃនេះ</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-sm text-slate-600">
                            <span class="w-2.5 h-2.5 rounded-full bg-green-400"></span>មានវត្តមាន
                        </span>
                        <span class="font-semibold text-slate-800">{{ $stats['present_today'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-sm text-slate-600">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-400"></span>អវត្តមាន
                        </span>
                        <span class="font-semibold text-slate-800">{{ $stats['absent_today'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-sm text-slate-600">
                            <span class="w-2.5 h-2.5 rounded-full bg-yellow-400"></span>យឺត
                        </span>
                        <span class="font-semibold text-slate-800">{{ $stats['late_today'] }}</span>
                    </div>
                </div>
            </div>

            {{-- System info --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                <h2 class="font-semibold text-slate-800 mb-4">ព័ត៌មានប្រព័ន្ធ</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">មុខវិជ្ជា</span>
                        <span class="font-medium text-slate-800">{{ $stats['subjects'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">បុគ្គលិក</span>
                        <span class="font-medium text-slate-800">{{ $stats['staff'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">សៀវភៅ</span>
                        <span class="font-medium text-slate-800">{{ $stats['books'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">អ្នកប្រើប្រាស់</span>
                        <span class="font-medium text-slate-800">{{ $stats['users'] }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

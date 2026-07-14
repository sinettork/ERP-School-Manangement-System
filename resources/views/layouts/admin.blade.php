<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{
        sidebarOpen: true,
        openGroup: '{{ collect(['students','teachers','classes','subjects','academic-years'])->first(fn($r) => request()->routeIs($r.'.*')) ? 'academic' : (collect(['attendance','exams','scores','report-cards'])->first(fn($r) => request()->routeIs($r.'.*')) ? 'grade' : (collect(['payments','inventory'])->first(fn($r) => request()->routeIs($r.'.*')) ? 'finance' : (collect(['staff','library','announcements'])->first(fn($r) => request()->routeIs($r.'.*')) ? 'other' : (collect(['users','settings'])->first(fn($r) => request()->routeIs($r.'.*')) ? 'system' : 'academic')))) }}'
      }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        /* Hide scrollbar but keep scroll */
        .scrollbar-hidden { scrollbar-width: none; -ms-overflow-style: none; }
        .scrollbar-hidden::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-slate-100 font-sans antialiased" x-cloak>
<div class="flex h-screen overflow-hidden">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="flex flex-col bg-slate-900 transition-all duration-300 ease-in-out flex-shrink-0"
           :class="sidebarOpen ? 'w-64' : 'w-16'">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-4 py-4 border-b border-slate-700 h-16 flex-shrink-0">
            <div class="flex-shrink-0 w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0121 21H3a12.083 12.083 0 012.84-10.422L12 14z"/>
                </svg>
            </div>
            <span class="text-white font-bold text-sm truncate" x-show="sidebarOpen" x-transition>
                {{ \App\Models\SchoolInformation::first()?->school_name ?? config('app.name') }}
            </span>
        </div>

        {{-- Nav — scrollable, hidden scrollbar --}}
        <nav class="flex-1 overflow-y-auto scrollbar-hidden py-3 px-2 space-y-0.5">

            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
               class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 11a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z"/>
                </svg>
                <span x-show="sidebarOpen" class="truncate" x-transition>ផ្ទាំងគ្រប់គ្រង</span>
            </a>


            {{-- ===== GROUP: សិក្សា ===== --}}
            <div x-data>
                <button @click="sidebarOpen ? openGroup = (openGroup === 'academic' ? '' : 'academic') : openGroup = 'academic'; sidebarOpen = true"
                        class="sidebar-link w-full {{ request()->routeIs(['students.*','teachers.*','classes.*','subjects.*','academic-years.*']) ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span x-show="sidebarOpen" class="flex-1 truncate text-left" x-transition>សិក្សា</span>
                    <svg x-show="sidebarOpen" class="w-4 h-4 flex-shrink-0 transition-transform" :class="openGroup==='academic' ? 'rotate-180':''" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-transition>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="openGroup === 'academic'" x-collapse class="pl-3 mt-0.5 space-y-0.5">
                    <a href="{{ route('students.index') }}" class="sidebar-link sidebar-sub {{ request()->routeIs('students.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="truncate">សិស្ស</span>
                    </a>
                    <a href="{{ route('teachers.index') }}" class="sidebar-link sidebar-sub {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span class="truncate">គ្រូបង្រៀន</span>
                    </a>
                    <a href="{{ route('classes.index') }}" class="sidebar-link sidebar-sub {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span class="truncate">ថ្នាក់រៀន</span>
                    </a>
                    <a href="{{ route('subjects.index') }}" class="sidebar-link sidebar-sub {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <span class="truncate">មុខវិជ្ជា</span>
                    </a>
                    <a href="{{ route('academic-years.index') }}" class="sidebar-link sidebar-sub {{ request()->routeIs('academic-years.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="truncate">ឆ្នាំសិក្សា</span>
                    </a>
                </div>
            </div>


            {{-- ===== GROUP: វត្តមាន & ការប្រឡង ===== --}}
            <div x-data>
                <button @click="sidebarOpen ? openGroup = (openGroup === 'grade' ? '' : 'grade') : openGroup = 'grade'; sidebarOpen = true"
                        class="sidebar-link w-full {{ request()->routeIs(['attendance.*','exams.*','scores.*','report-cards.*']) ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    <span x-show="sidebarOpen" class="flex-1 truncate text-left" x-transition>វត្តមាន & ការប្រឡង</span>
                    <svg x-show="sidebarOpen" class="w-4 h-4 flex-shrink-0 transition-transform" :class="openGroup==='grade' ? 'rotate-180':''" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-transition>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="openGroup === 'grade'" x-collapse class="pl-3 mt-0.5 space-y-0.5">
                    <a href="{{ route('attendance.index') }}" class="sidebar-link sidebar-sub {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="truncate">វត្តមាន</span>
                    </a>
                    <a href="{{ route('exams.index') }}" class="sidebar-link sidebar-sub {{ request()->routeIs('exams.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span class="truncate">ការប្រឡង</span>
                    </a>
                    <a href="{{ route('scores.index') }}" class="sidebar-link sidebar-sub {{ request()->routeIs('scores.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span class="truncate">បញ្ចូលពិន្ទុ</span>
                    </a>
                    <a href="{{ route('report-cards.index') }}" class="sidebar-link sidebar-sub {{ request()->routeIs('report-cards.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        <span class="truncate">សៀវភៅពិន្ទុ</span>
                    </a>
                </div>
            </div>


            {{-- ===== GROUP: ហិរញ្ញវត្ថុ ===== --}}
            <div x-data>
                <button @click="sidebarOpen ? openGroup = (openGroup === 'finance' ? '' : 'finance') : openGroup = 'finance'; sidebarOpen = true"
                        class="sidebar-link w-full {{ request()->routeIs(['payments.*','inventory.*']) ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span x-show="sidebarOpen" class="flex-1 truncate text-left" x-transition>ហិរញ្ញវត្ថុ</span>
                    <svg x-show="sidebarOpen" class="w-4 h-4 flex-shrink-0 transition-transform" :class="openGroup==='finance' ? 'rotate-180':''" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-transition>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="openGroup === 'finance'" x-collapse class="pl-3 mt-0.5 space-y-0.5">
                    <a href="{{ route('payments.index') }}" class="sidebar-link sidebar-sub {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        <span class="truncate">ថ្លៃសិក្សា</span>
                    </a>
                    <a href="{{ route('inventory.index') }}" class="sidebar-link sidebar-sub {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <span class="truncate">សម្ភារៈ</span>
                    </a>
                </div>
            </div>


            {{-- ===== GROUP: ផ្សេងៗ ===== --}}
            <div x-data>
                <button @click="sidebarOpen ? openGroup = (openGroup === 'other' ? '' : 'other') : openGroup = 'other'; sidebarOpen = true"
                        class="sidebar-link w-full {{ request()->routeIs(['staff.*','library.*','announcements.*']) ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    <span x-show="sidebarOpen" class="flex-1 truncate text-left" x-transition>ផ្សេងៗ</span>
                    <svg x-show="sidebarOpen" class="w-4 h-4 flex-shrink-0 transition-transform" :class="openGroup==='other' ? 'rotate-180':''" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-transition>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="openGroup === 'other'" x-collapse class="pl-3 mt-0.5 space-y-0.5">
                    <a href="{{ route('staff.index') }}" class="sidebar-link sidebar-sub {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span class="truncate">បុគ្គលិក</span>
                    </a>
                    <a href="{{ route('library.index') }}" class="sidebar-link sidebar-sub {{ request()->routeIs('library.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                        <span class="truncate">បណ្ណាល័យ</span>
                    </a>
                    <a href="{{ route('announcements.index') }}" class="sidebar-link sidebar-sub {{ request()->routeIs('announcements.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                        <span class="truncate">សេចក្ដីជូនដំណឹង</span>
                    </a>
                </div>
            </div>


            {{-- ===== GROUP: ប្រព័ន្ធ ===== --}}
            <div x-data>
                <button @click="sidebarOpen ? openGroup = (openGroup === 'system' ? '' : 'system') : openGroup = 'system'; sidebarOpen = true"
                        class="sidebar-link w-full {{ request()->routeIs(['users.*','settings.*']) ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span x-show="sidebarOpen" class="flex-1 truncate text-left" x-transition>ប្រព័ន្ធ</span>
                    <svg x-show="sidebarOpen" class="w-4 h-4 flex-shrink-0 transition-transform" :class="openGroup==='system' ? 'rotate-180':''" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-transition>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="openGroup === 'system'" x-collapse class="pl-3 mt-0.5 space-y-0.5">
                    <a href="{{ route('users.index') }}" class="sidebar-link sidebar-sub {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span class="truncate">អ្នកប្រើប្រាស់</span>
                    </a>
                    <a href="{{ route('settings.index') }}" class="sidebar-link sidebar-sub {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                        <span class="truncate">ការកំណត់</span>
                    </a>
                </div>
            </div>

        </nav>

        {{-- Collapse toggle --}}
        <div class="border-t border-slate-700 p-2 flex-shrink-0">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white transition-colors">
                <svg class="w-5 h-5 transition-transform duration-300" :class="sidebarOpen ? '' : 'rotate-180'"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                </svg>
                <span x-show="sidebarOpen" class="text-sm" x-transition>បង្រួម</span>
            </button>
        </div>
    </aside>


    {{-- ===== MAIN CONTENT ===== --}}
    <div class="flex flex-col flex-1 overflow-hidden">

        {{-- Topbar --}}
        <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 flex-shrink-0">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen"
                        class="p-2 rounded-lg text-slate-500 hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="text-lg font-semibold text-slate-800">@yield('page-title', 'ផ្ទាំងគ្រប់គ្រង')</h1>
            </div>

            <div class="flex items-center gap-3">
                @php $activeYear = \App\Models\AcademicYear::where('is_active', true)->first(); @endphp
                @if($activeYear)
                    <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $activeYear->name }}
                    </span>
                @endif

                <button class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </button>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                            class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-slate-100 transition-colors">
                        <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="hidden sm:block text-left">
                            <p class="text-sm font-medium text-slate-800 leading-none">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ auth()->user()->getRoleNames()->first() }}</p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak
                         class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-200 py-1 z-50">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            គណនីរបស់ខ្ញុំ
                        </a>
                        <div class="border-t border-slate-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                ចាកចេញ
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Flash messages --}}
        <div class="px-6 pt-4 space-y-2">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                     class="flex items-center gap-3 p-3 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     class="flex items-center gap-3 p-3 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    {{ session('error') }}
                </div>
            @endif
        </div>

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>

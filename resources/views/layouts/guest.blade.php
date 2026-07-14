<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-100">

<div class="min-h-screen flex">

    {{-- Left decorative panel (hidden on mobile) --}}
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-700 via-indigo-800 to-slate-900 flex-col items-center justify-center p-12 relative overflow-hidden">
        {{-- Background circles --}}
        <div class="absolute top-0 left-0 w-72 h-72 bg-indigo-500 rounded-full opacity-10 -translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-400 rounded-full opacity-10 translate-x-1/3 translate-y-1/3"></div>

        <div class="relative z-10 text-center">
            {{-- School icon --}}
            <div class="w-20 h-20 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422A12.083 12.083 0 0121 21H3a12.083 12.083 0 012.84-10.422L12 14z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">
                {{ \App\Models\SchoolInformation::first()?->school_name ?? config('app.name') }}
            </h1>
            <p class="text-indigo-200 text-sm leading-relaxed max-w-xs">
                ប្រព័ន្ធគ្រប់គ្រងសាលារៀនពេញលេញ<br>
                សម្រាប់គ្រប់គ្រងទិន្នន័យសិស្ស គ្រូ និងការគ្រប់គ្រងទូទៅ
            </p>

            {{-- Feature list --}}
            <div class="mt-8 space-y-3 text-left">
                @foreach([
                    ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'label' => 'គ្រប់គ្រងសិស្ស និងគ្រូបង្រៀន'],
                    ['icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'label' => 'ប្រឡង ពិន្ទុ និងសៀវភៅពិន្ទុ'],
                    ['icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z', 'label' => 'ប្រព័ន្ធហិរញ្ញវត្ថុ'],
                ] as $feat)
                <div class="flex items-center gap-3 text-indigo-100 text-sm">
                    <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feat['icon'] }}"/>
                        </svg>
                    </div>
                    <span>{{ $feat['label'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Right: auth form panel --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-12">
        <div class="w-full max-w-md">
            {{-- Mobile logo --}}
            <div class="lg:hidden text-center mb-8">
                <div class="w-14 h-14 bg-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0121 21H3a12.083 12.083 0 012.84-10.422L12 14z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-slate-800">{{ config('app.name') }}</h2>
            </div>

            {{-- Card --}}
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

</body>
</html>

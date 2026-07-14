@props(['title', 'createRoute' => null, 'createLabel' => 'បន្ថែមថ្មី'])

<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-slate-800">{{ $title }}</h2>
    @if($createRoute)
        <a href="{{ $createRoute }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            {{ $createLabel }}
        </a>
    @endif
</div>

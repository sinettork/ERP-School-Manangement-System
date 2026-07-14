@props(['label', 'name', 'required' => false, 'value' => ''])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 mb-1">
        {{ $label }}@if($required)<span class="text-red-500 ml-0.5">*</span>@endif
    </label>
    <select
        id="{{ $name }}"
        name="{{ $name }}"
        @if($required) required @endif
        class="block w-full rounded-lg border-slate-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 @error($name) border-red-300 @enderror"
    >
        {{ $slot }}
    </select>
    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>

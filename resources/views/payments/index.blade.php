@extends('layouts.admin')
@section('title','ថ្លៃសិក្សា')
@section('page-title','គ្រប់គ្រងថ្លៃសិក្សា')

@section('content')
{{-- Summary --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
    <x-card class="p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        <div><p class="text-xs text-slate-500">ទូទាត់ហើយ</p><p class="text-xl font-bold text-green-700">{{ number_format($totalPaid) }} ៛</p></div>
    </x-card>
    <x-card class="p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        <div><p class="text-xs text-slate-500">មិនទាន់ទូទាត់</p><p class="text-xl font-bold text-red-700">{{ number_format($totalUnpaid) }} ៛</p></div>
    </x-card>
    <x-card class="p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        <div><p class="text-xs text-slate-500">ការទូទាត់សរុប</p><p class="text-xl font-bold text-indigo-700">{{ $payments->total() }}</p></div>
    </x-card>
</div>

<x-page-header title="ការទូទាត់ទាំងអស់" :createRoute="route('payments.create')" createLabel="កត់ត្រាថ្មី"/>

<x-card class="mb-4">
    <form method="GET" class="flex flex-wrap gap-3 p-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="ស្វែងរកតាមឈ្មោះ ឬ លេខកូដ..."
               class="flex-1 min-w-48 rounded-lg border-slate-300 text-sm"/>
        <select name="status" class="rounded-lg border-slate-300 text-sm" onchange="this.form.submit()">
            <option value="">-- ស្ថានភាព --</option>
            <option value="paid"    {{ request('status')=='paid'    ? 'selected':'' }}>បានបង់</option>
            <option value="partial" {{ request('status')=='partial' ? 'selected':'' }}>បង់មួយផ្នែក</option>
            <option value="unpaid"  {{ request('status')=='unpaid'  ? 'selected':'' }}>មិនទាន់បង់</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg">ស្វែងរក</button>
        <a href="{{ route('payments.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm rounded-lg">សម្អាត</a>
    </form>
</x-card>

<x-card>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">សិស្ស</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ចំនួន</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ប្រភេទ</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">រយៈពេល</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ថ្ងៃ</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">ស្ថានភាព</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">សកម្មភាព</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($payments as $p)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">
                        <p class="font-medium text-slate-800">{{ $p->student->name_kh }}</p>
                        <p class="text-xs text-slate-400">{{ $p->student->student_code }}</p>
                    </td>
                    <td class="px-4 py-3 font-semibold text-indigo-700">{{ number_format($p->amount) }} ៛</td>
                    <td class="px-4 py-3 text-slate-600 text-xs">{{ match($p->payment_type){ 'monthly'=>'ខែ','quarterly'=>'ត្រីមាស',default=>'ឆ្នាំ' } }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $p->period ?? '—' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $p->payment_date->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">
                        @php $sc = match($p->status){ 'paid'=>'bg-green-100 text-green-800','partial'=>'bg-yellow-100 text-yellow-800',default=>'bg-red-100 text-red-800' }; @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $sc }}">
                            {{ match($p->status){ 'paid'=>'បានបង់','partial'=>'មួយផ្នែក',default=>'មិនទាន់' } }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-1">
                            <x-table-actions
                                :showRoute="route('payments.show',$p)"
                                :editRoute="route('payments.edit',$p)"
                                :deleteRoute="route('payments.destroy',$p)"
                            />
                            @if($p->receipt)
                            <a href="{{ route('payments.receipt',$p) }}" target="_blank"
                               class="p-1.5 text-slate-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="បោះពុម្ព">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-10 text-center text-slate-400">មិនទាន់មានទិន្នន័យ</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($payments->hasPages())
    <div class="px-4 py-3 border-t border-slate-100">{{ $payments->links() }}</div>
    @endif
</x-card>
@endsection

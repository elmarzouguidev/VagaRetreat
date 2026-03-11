@extends('layouts.admin')

@php
    $title = $type === 'tour' ? $priceable->title : $priceable->name;
    $entityLabel = $type === 'tour' ? 'Base Tour Price' : 'Accommodation Price Option';
@endphp

@section('title', 'Edit Price - ' . $title)
@section('page-title', 'Edit ' . $entityLabel)

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div>
            <x-admin.button :href="$backRoute" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to {{ $type === 'tour' ? 'Tour Details' : 'Tour Accommodations' }}
            </x-admin.button>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900">Edit price: {{ $price->name }}</h2>
                <p class="text-sm text-slate-500 mt-1">For {{ $title }}</p>
            </div>
            
            <form action="{{ $updateRoute }}" method="POST" class="p-6 space-y-6 cursor-text">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <x-admin.form-input label="Price Label" name="name" :value="$price->name" required />
                     
                     <div>
                        <label for="currency" class="block text-sm font-semibold text-slate-700 mb-1.5">Currency</label>
                        <select name="currency" id="currency" required class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all duration-200">
                            @foreach(\App\Enums\Utilities\ConversionCurrencyType::options() as $value => $label)
                                <option value="{{ $value }}" {{ old('currency', $price->currency->value ?? $price->currency) === $value ? 'selected' : '' }}>
                                    {{ $label }} ({{ \App\Enums\Utilities\ConversionCurrencyType::from($value)->getSymbol() }})
                                </option>
                            @endforeach
                        </select>
                        @error('currency')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p>
                        @enderror
                     </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <x-admin.form-input label="Amount" name="amount" type="number" step="0.01" min="0" :value="$price->amount / 100" required />
                     <x-admin.form-input label="Expiry Date (Optional)" name="expired_at" type="datetime-local" :value="$price->expired_at ? $price->expired_at->format('Y-m-d\TH:i') : ''" />
                </div>

                <div class="flex flex-col gap-3 py-4 border-t border-slate-100">
                    <label class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                        <input type="checkbox" name="is_default" value="1" class="w-5 h-5 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500/20" @checked($price->is_default)>
                        Set as Default Price (replaces any previous default)
                    </label>
                    <label class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                        <input type="checkbox" name="is_active" value="1" class="w-5 h-5 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500/20" @checked($price->is_active)>
                        Active (Bookable)
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button :href="$backRoute" variant="outline">Cancel</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Update Price Option</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

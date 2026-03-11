@props([
    'href' => null,
    'variant' => 'primary',
    'type' => 'button',
])

@php
    $variants = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 border-transparent',
        'success' => 'bg-green-600 text-white hover:bg-green-700 border-transparent',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 border-transparent',
        'outline' => 'bg-white text-slate-700 hover:bg-slate-50 border-slate-300',
        'secondary' => 'bg-slate-100 text-slate-700 hover:bg-slate-200 border-transparent',
    ];
    $classes = 'inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium rounded-lg border transition ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif

@props([
    'title' => '',
    'value' => '0',
    'color' => 'blue',
    'href' => null,
    'buttonText' => 'View',
])

@php
    $colorMap = [
        'blue' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'value' => 'text-blue-600'],
        'green' => ['bg' => 'bg-green-100', 'text' => 'text-green-600', 'value' => 'text-green-600'],
        'emerald' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600', 'value' => 'text-emerald-600'],
        'amber' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-600', 'value' => 'text-amber-600'],
        'violet' => ['bg' => 'bg-violet-100', 'text' => 'text-violet-600', 'value' => 'text-violet-600'],
        'rose' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-600', 'value' => 'text-rose-600'],
        'red' => ['bg' => 'bg-red-100', 'text' => 'text-red-600', 'value' => 'text-red-600'],
        'purple' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'value' => 'text-purple-600'],
    ];
    $colors = $colorMap[$color] ?? $colorMap['blue'];
@endphp

<div class="bg-white rounded-lg shadow-sm border border-slate-200 p-5 hover:shadow-md transition">
    <div class="flex items-center gap-4">
        <div class="shrink-0 p-3 {{ $colors['bg'] }} rounded-lg">
            {{ $icon }}
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-slate-600 truncate">{{ $title }}</p>
            <p class="text-2xl font-bold text-slate-900">{{ $value }}</p>
        </div>
    </div>
    @if($href)
        <div class="mt-4 pt-3 border-t border-slate-100">
            <a href="{{ $href }}" class="text-sm font-medium {{ $colors['text'] }} hover:underline">
                {{ $buttonText }} →
            </a>
        </div>
    @endif
</div>

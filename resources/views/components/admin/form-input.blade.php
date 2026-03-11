@props(['label', 'name', 'type' => 'text', 'required' => false, 'value' => '', 'placeholder' => ''])

@php
    $baseClasses = "w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all duration-200";
    $errorClasses = $errors->has($name) ? ' border-red-300 bg-red-50 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500/20' : '';
    $classes = $baseClasses . $errorClasses;
@endphp

<div class="space-y-1.5 cursor-text" x-data="{ focused: false }" @click.self="$refs.input.focus()">
    <label for="{{ $name }}" class="block text-sm font-semibold text-slate-700">
        {{ $label }} @if($required)<span class="text-red-500 ml-0.5">*</span>@endif
    </label>
    <div class="relative">
        <input 
            x-ref="input"
            @focus="focused = true"
            @blur="focused = false"
            type="{{ $type }}" 
            name="{{ $name }}" 
            id="{{ $name }}" 
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => $classes]) }}
        >
    </div>
    @error($name)
        <p class="text-[13px] font-medium text-red-600 flex items-center gap-1.5 mt-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ $message }}
        </p>
    @enderror
</div>

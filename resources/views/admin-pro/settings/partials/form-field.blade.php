@props([
    'type' => 'text',
    'name' => '',
    'label' => '',
    'value' => '',
    'placeholder' => '',
    'help' => '',
    'required' => false,
    'options' => [],
    'rows' => 3,
])

<div class="space-y-2">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-slate-700">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    @if ($type === 'text' || $type === 'email' || $type === 'password' || $type === 'url' || $type === 'number')
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
            value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error($name) border-red-500 @enderror">
    @elseif($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}"
            placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error($name) border-red-500 @enderror">{{ old($name, $value) }}</textarea>
    @elseif($type === 'select')
        <select name="{{ $name }}" id="{{ $name }}" {{ $required ? 'required' : '' }}
            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error($name) border-red-500 @enderror">
            @foreach ($options as $key => $label)
                <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    @elseif($type === 'file')
        <div class="space-y-2">
            @if ($value)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $value) }}" alt="Preview"
                        class="h-20 rounded border border-slate-200">
                </div>
            @endif
            <input type="file" name="{{ $name }}" id="{{ $name }}" accept="image/*"
                class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
        </div>
    @elseif($type === 'toggle')
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="{{ $name }}" id="{{ $name }}" value="1"
                {{ old($name, $value) ? 'checked' : '' }} class="sr-only peer">
            <div
                class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
            </div>
        </label>
    @endif

    @if ($help)
        <p class="text-xs text-slate-500">{{ $help }}</p>
    @endif

    @error($name)
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

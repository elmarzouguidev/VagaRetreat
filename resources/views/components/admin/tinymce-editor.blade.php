@props(['label', 'name', 'required' => false, 'value' => ''])

<div x-data="{
    value: @js(old($name, $value)),
    init() {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                target: this.$refs.editor,
                height: 400,
                menubar: false,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
                setup: (editor) => {
                    editor.on('change', (e) => {
                        this.value = editor.getContent();
                    });
                }
            });
        }
    }
}">
    <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 mb-1">
        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
    </label>
    
    <textarea 
        x-ref="editor"
        name="{{ $name }}" 
        id="{{ $name }}"
        x-model="value"
        class="hidden"
        {{ $attributes }}
    ></textarea>
    
    @error($name)
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
    
    @pushOnce('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
    @endPushOnce
</div>

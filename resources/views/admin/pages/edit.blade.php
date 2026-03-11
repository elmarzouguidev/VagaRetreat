@extends('layouts.admin')

@section('title', 'Edit CMS Page')
@section('page-title', 'Edit CMS Page')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div>
            <x-admin.button href="{{ route('admin.pages.index') }}" variant="outline">Back to Pages</x-admin.button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="text-lg font-medium text-slate-900">Edit CMS Page: {{ $page->title }}</h2>
            </div>
            <form method="POST" action="{{ route('admin.pages.update', $page) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <x-admin.form-input label="Title" name="title" :value="$page->title" required />
                     <x-admin.form-input label="Slug" name="slug" :value="$page->slug" />
                </div>
               
                <x-admin.textarea label="Excerpt" name="excerpt" rows="2" :value="$page->excerpt" placeholder="Brief summary of the page" />
                <x-admin.tinymce-editor label="Content" name="body" :value="$page->body ?? ''" />
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-admin.form-input label="Meta Title" name="meta_title" :value="$page->meta_title ?? ''" />
                    <x-admin.form-input label="Meta Description" name="meta_description" :value="$page->meta_description ?? ''" />
                </div>

                <label class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                    <input type="checkbox" name="is_published" value="1" class="w-5 h-5 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500/20" @checked($page->is_active ?? $page->is_published)>
                    Published
                </label>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.pages.index') }}" variant="outline">Cancel</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Update Page</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

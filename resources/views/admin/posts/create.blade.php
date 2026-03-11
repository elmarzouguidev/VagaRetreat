@extends('layouts.admin')

@section('title', 'Create Blog Post')
@section('page-title', 'Create Blog Post')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div>
            <x-admin.button href="{{ route('admin.posts.index') }}" variant="outline">Back to Posts</x-admin.button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="text-lg font-medium text-slate-900">New Blog Post</h2>
            </div>
            <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <x-admin.form-input label="Title" name="title" required />
                     
                     <div>
                        <label for="category_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Category</label>
                        <select name="category_id" id="category_id" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all duration-200">
                            <option value="">Select a Category...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->label ?? $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                     </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Featured Image</label>
                    <input type="file" name="featured_image" accept="image/*" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-lg text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 focus:outline-none focus:ring-4 focus:ring-blue-500/10 transition-all duration-200">
                    @error('featured_image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
               
                <x-admin.textarea label="Excerpt" name="excerpt" rows="2" placeholder="Brief summary of the post" />
                <x-admin.tinymce-editor label="Content" name="content" :value="old('content', '')" required />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-admin.form-input label="Publish Date" name="published_at" type="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" />
                    </div>
                </div>

                <label class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                    <input type="checkbox" name="is_published" value="1" class="w-5 h-5 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500/20" checked>
                    Publish Post
                </label>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.posts.index') }}" variant="outline">Cancel</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Create Post</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

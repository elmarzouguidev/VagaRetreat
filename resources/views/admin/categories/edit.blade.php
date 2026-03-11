@extends('layouts.admin')

@section('title', 'Edit Category: ' . $category->name)
@section('page-title', 'Edit Category')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <div>
            <x-admin.button href="{{ route('admin.categories.index') }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Categories
            </x-admin.button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="text-lg font-medium text-slate-900">Edit Category: {{ $category->name }}</h2>
            </div>
            
            <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <x-admin.form-input label="Category Name" name="name" :value="$category->name" required />
                <x-admin.form-input label="Slug" name="slug" :value="$category->slug" />

                <div class="flex flex-col gap-3 py-4 border-t border-slate-100">
                    <label class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                        <input type="checkbox" name="is_active" value="1" class="w-5 h-5 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500/20" @checked($category->is_active)>
                        Active (Visible on frontend selections)
                    </label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.categories.index') }}" variant="outline">Cancel</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Update Category</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

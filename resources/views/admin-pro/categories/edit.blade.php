@extends('layouts.admin')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <x-admin.button href="{{ route('admin:category:list') }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Categories
                </x-admin.button>
                
                <x-admin.button href="{{ route('admin:category:show', $category) }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View Category
                </x-admin.button>
            </div>
            
            <div class="text-sm text-gray-500">
                Last updated: {{ $category->updated_at->format('M j, Y g:i A') }}
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="text-lg font-medium text-gray-900">Edit Category</h2>
            <p class="mt-1 text-sm text-gray-600">Update the category information below.</p>
        </div>

        <form method="POST" action="{{ route('admin:category:update', $category) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <x-admin.form-input 
                label="Name" 
                name="name" 
                :value="$category->name"
                placeholder="Enter category name"
                required />

            <x-admin.form-input 
                label="Slug" 
                name="slug" 
                :value="$category->slug"
                placeholder="category-slug" />

            <x-admin.textarea 
                label="Description" 
                name="description" 
                :value="$category->description"
                placeholder="Brief description of the category"
                rows="4" />

            <!-- SEO Section -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Settings</h3>
                
                <x-admin.form-input 
                    label="Meta Title" 
                    name="meta_title" 
                    :value="$category->seo->meta_title ?? ''"
                    placeholder="SEO title (leave empty to use category name)" />

                <x-admin.textarea 
                    label="Meta Description" 
                    name="meta_description" 
                    :value="$category->seo->meta_description ?? ''"
                    placeholder="SEO description"
                    rows="3" />

                <x-admin.form-input 
                    label="Meta Keywords" 
                    name="meta_keywords" 
                    :value="$category->seo && $category->seo->meta_keywords ? implode(', ', $category->seo->meta_keywords) : ''"
                    placeholder="keyword1, keyword2, keyword3" />
            </div>

            <!-- Category Stats -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Category Statistics</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Posts:</span>
                        <span class="font-medium">{{ $category->posts_count ?? 0 }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Created:</span>
                        <span class="font-medium">{{ $category->created_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-slate-200/70">
                <x-admin.button href="{{ route('admin:category:list') }}" variant="outline">
                    Cancel
                </x-admin.button>
                
                <x-admin.button type="submit" variant="primary">
                    Update Category
                </x-admin.button>
            </div>
        </form>
    </div>
</div>
@endsection

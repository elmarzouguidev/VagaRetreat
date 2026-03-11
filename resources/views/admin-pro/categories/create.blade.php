@extends('layouts.admin')

@section('title', 'Create Category')
@section('page-title', 'Create New Category')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center space-x-4">
            <x-admin.button href="{{ route('admin:category:list') }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Categories
            </x-admin.button>
        </div>
    </div>

    <!-- Form -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="text-lg font-medium text-gray-900">Category Details</h2>
            <p class="mt-1 text-sm text-gray-600">Fill in the information below to create a new category.</p>
        </div>

        <form method="POST" action="{{ route('admin:category:create.store') }}" class="p-6 space-y-6">
            @csrf

            <x-admin.form-input 
                label="Name" 
                name="name" 
                placeholder="Enter category name"
                required />

            <x-admin.textarea 
                label="Description" 
                name="description" 
                placeholder="Brief description of the category"
                rows="4" />

            <!-- SEO Section -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Settings</h3>
                
                <x-admin.form-input 
                    label="Meta Title" 
                    name="meta_title" 
                    placeholder="SEO title (leave empty to use category name)" />

                <x-admin.textarea 
                    label="Meta Description" 
                    name="meta_description" 
                    placeholder="SEO description"
                    rows="3" />

                <x-admin.form-input 
                    label="Meta Keywords" 
                    name="meta_keywords" 
                    placeholder="keyword1, keyword2, keyword3" />
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-slate-200/70">
                <x-admin.button href="{{ route('admin:category:list') }}" variant="outline">
                    Cancel
                </x-admin.button>
                
                <x-admin.button type="submit" variant="primary">
                    Create Category
                </x-admin.button>
            </div>
        </form>
    </div>
</div>

@endsection

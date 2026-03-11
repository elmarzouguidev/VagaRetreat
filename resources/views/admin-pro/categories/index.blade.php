@extends('layouts.admin')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
<div class="space-y-6">
    <!-- Header with Create Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Categories</h1>
            <p class="mt-1 text-sm text-gray-600">Organize your content with categories</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <x-admin.button href="{{ route('admin:category:create') }}" variant="primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create New Category
            </x-admin.button>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="admin-card p-6">
        <form method="GET" action="{{ route('admin:category:list') }}" class="flex items-end space-x-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search categories by name or description..."
                       class="admin-form-input">
            </div>
            
            <div class="flex space-x-2">
                <x-admin.button type="submit" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </x-admin.button>
                
                @if(request('search'))
                    <x-admin.button href="{{ route('admin:category:list') }}" variant="outline">
                        Clear
                    </x-admin.button>
                @endif
            </div>
        </form>
    </div>

    <!-- Categories Table -->
    <x-admin.table :headers="['Name', 'Description', 'Posts Count', 'Created', 'Actions']">
        @forelse($categories ?? [] as $category)
            <tr class="hover:bg-slate-50/70">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div>
                            <div class="text-sm font-medium text-gray-900">
                                <a href="{{ route('admin:category:show', $category) }}" class="hover:text-blue-600">
                                    {{ $category->name }}
                                </a>
                            </div>
                            <div class="text-sm text-gray-500">{{ $category->slug }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900">
                        {{ Str::limit($category->description ?? 'No description', 60) }}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $category->posts_count ?? 0 }} posts
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $category->created_at->format('M j, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center space-x-2">
                        <x-admin.button href="{{ route('admin:category:show', $category) }}" variant="outline" size="sm">
                            View
                        </x-admin.button>
                        <x-admin.button href="{{ route('admin:category:edit', $category) }}" variant="primary" size="sm">
                            Edit
                        </x-admin.button>
                        <form method="POST" action="{{ route('admin:category:destroy', $category) }}" class="inline" 
                              onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <x-admin.button type="submit" variant="danger" size="sm">
                                Delete
                            </x-admin.button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center">
                    <div class="text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No categories found</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new category.</p>
                        <div class="mt-6">
                            <x-admin.button href="{{ route('admin:category:create') }}" variant="primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create New Category
                            </x-admin.button>
                        </div>
                    </div>
                </td>
            </tr>
        @endforelse
    </x-admin.table>

    <!-- Pagination -->
    @if(isset($categories) && $categories->hasPages())
        <div class="admin-card px-4 py-3 border-t border-slate-200/70 sm:px-6">
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection

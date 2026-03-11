@extends('layouts.admin')

@section('title', $category->name)
@section('page-title', 'View Category')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <x-admin.button href="{{ route('admin:category:list') }}" variant="outline">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Categories
                    </x-admin.button>
                </div>

                <div class="flex items-center space-x-3">
                    <x-admin.button href="{{ route('admin:category:edit', $category) }}" variant="primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Edit Category
                    </x-admin.button>

                    <form method="POST" action="{{ route('admin:category:destroy', $category) }}" class="inline"
                        onsubmit="return confirm('Are you sure you want to delete this category?')">
                        @csrf
                        @method('DELETE')
                        <x-admin.button type="submit" variant="danger">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Delete
                        </x-admin.button>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Category Information -->
                <div class="admin-card p-6">
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $category->name }}</h1>

                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            <span>Created {{ $category->created_at?->format('F j, Y') }}</span>
                            <span>•</span>
                            <span>{{ $category->posts_count ?? 0 }} posts</span>
                        </div>
                    </div>

                    @if ($category->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $category->description }}</p>
                        </div>
                    @endif
                </div>

                <!-- SEO Information -->
                @if ($category->seo)
                    <div class="mt-6 admin-card p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Information</h3>

                        <div class="space-y-4">
                            @if ($category->seo->meta_title)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Meta Title</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $category->seo->meta_title }}</p>
                                </div>
                            @endif

                            @if ($category->seo->meta_description)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Meta Description</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $category->seo->meta_description }}</p>
                                </div>
                            @endif

                            @if ($category->seo->meta_keywords)
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700">Meta Keywords</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ implode(', ', $category->seo->meta_keywords) }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Posts in this Category -->
                @if ($category->posts && $category->posts->count() > 0)
                    <div class="mt-6 admin-card">
                        <div class="admin-card-header">
                            <h3 class="text-lg font-medium text-gray-900">Posts in this Category</h3>
                        </div>

                        <div class="divide-y divide-gray-200">
                            @foreach ($category->posts->take(10) as $post)
                                <div class="px-6 py-4 hover:bg-slate-50/70">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-gray-900">
                                                <a href="{{ route('admin:post:show', $post) }}"
                                                    class="hover:text-blue-600">
                                                    {{ $post->title }}
                                                </a>
                                            </h4>
                                            <p class="mt-1 text-sm text-gray-500">
                                                {{ Str::limit($post->description ?? '', 100) }}
                                            </p>
                                            <div class="mt-2 flex items-center space-x-4 text-xs text-gray-400">
                                                <span>{{ $post->created_at->format('M j, Y') }}</span>
                                                <span>•</span>
                                                <span>{{ $post->user->prenom ?? 'Unknown' }}</span>
                                            </div>
                                        </div>

                                        <div class="ml-4">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $post->status?->badgeClasses() }}">
                                                {{ $post->status?->label() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if ($category->posts->count() > 10)
                                <div class="px-6 py-4 text-center">
                                    <p class="text-sm text-gray-500">
                                        And {{ $category->posts->count() - 10 }} more posts...
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Category Details -->
                <div class="admin-card p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Category Details</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Slug</label>
                            <p class="mt-1 text-sm text-gray-900 font-mono bg-slate-50/70 px-2 py-1 rounded">
                                {{ $category->slug }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Posts Count</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $category->posts_count ?? 0 }} posts</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Created</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $category->created_at->format('F j, Y g:i A') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $category->updated_at->format('F j, Y g:i A') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">UUID</label>
                            <p class="mt-1 text-xs text-gray-500 font-mono bg-slate-50/70 px-2 py-1 rounded break-all">
                                {{ $category->uuid }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="admin-card p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>

                    <div class="space-y-3">
                        <x-admin.button href="{{ route('admin:post:create') }}?category={{ $category->id }}"
                            variant="success" class="w-full">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Create Post in Category
                        </x-admin.button>

                        <x-admin.button href="{{ route('admin:category:create') }}" variant="outline" class="w-full">
                            Create New Category
                        </x-admin.button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

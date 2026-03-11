@extends('layouts.admin')

@section('title', 'View Comment')
@section('page-title', 'View Comment')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <x-admin.button href="{{ route('admin:comment:list') }}" variant="outline">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Comments
                    </x-admin.button>

                    @if ($comment->post)
                        <x-admin.button href="{{ route('admin:post:show', $comment->post) }}" variant="outline">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            View Post
                        </x-admin.button>
                    @endif
                </div>

                <div class="flex items-center space-x-3">
                    @if ($comment->is_active)
                        <form method="POST" action="{{ route('admin:comment:update', $comment) }}" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_active" value="0">
                            <x-admin.button type="submit" variant="warning">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728">
                                    </path>
                                </svg>
                                Deactivate
                            </x-admin.button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin:comment:update', $comment) }}" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_active" value="1">
                            <x-admin.button type="submit" variant="success">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Activate
                            </x-admin.button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin:comment:destroy', $comment) }}" class="inline"
                        onsubmit="return confirm('Are you sure you want to delete this comment?')">
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
                <!-- Comment Content -->
                <div class="admin-card p-6">
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h1 class="text-2xl font-bold text-gray-900">Comment Details</h1>

                            @if ($comment->is_active)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Active
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Inactive
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4">
                            <span>By {{ $comment->name }}</span>
                            <span>•</span>
                            <span>{{ $comment->created_at?->format('F j, Y g:i A') }}</span>
                        </div>
                    </div>

                    <!-- Comment Text -->
                    <div class="prose max-w-none">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Comment</h3>
                        <div class="admin-inset p-4">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $comment->content }}</p>
                        </div>
                    </div>
                </div>

                <!-- Related Post -->
                @if ($comment->post)
                    <div class="mt-6 admin-card p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Related Post</h3>

                        <div class="admin-inset p-4 hover:bg-slate-50/70">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="text-lg font-medium text-gray-900 mb-2">
                                        <a href="{{ route('admin:post:show', $comment->post) }}"
                                            class="hover:text-blue-600">
                                            {{ $comment->post->title }}
                                        </a>
                                    </h4>

                                    @if ($comment->post?->description)
                                        <p class="text-gray-600 mb-3">{{ Str::limit($comment->post?->description, 150) }}
                                        </p>
                                    @endif

                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span>{{ $comment->post?->created_at?->format('M j, Y') }}</span>
                                        <span>•</span>
                                        <span>{{ $comment->post?->user?->prenom ?? 'Unknown' }}</span>
                                        @if ($comment->post?->category)
                                            <span>•</span>
                                            <span>{{ $comment->post?->category?->name }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="ml-4">

                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $comment->post?->status?->badgeClasses() }}">
                                        {{ $comment->post?->status?->label() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Comment Details -->
                <div class="admin-card p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Comment Information</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Author Name</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $comment->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">
                                <a href="mailto:{{ $comment->email }}" class="text-blue-600 hover:text-blue-500">
                                    {{ $comment->email }}
                                </a>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <p class="mt-1">
                                @if ($comment->is_active)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Created</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $comment->created_at?->format('F j, Y g:i A') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $comment->updated_at?->format('F j, Y g:i A') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">UUID</label>
                            <p class="mt-1 text-xs text-gray-500 font-mono bg-slate-50/70 px-2 py-1 rounded break-all">
                                {{ $comment->uuid }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="admin-card p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>

                    <div class="space-y-3">
                        <x-admin.button href="mailto:{{ $comment->email }}" variant="outline" class="w-full">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            Email Author
                        </x-admin.button>

                        @if ($comment->post)
                            <x-admin.button href="{{ route('admin:post:show', $comment->post) }}" variant="outline"
                                class="w-full">
                                View Related Post
                            </x-admin.button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

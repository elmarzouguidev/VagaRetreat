@extends('layouts.admin')

@section('title', 'Comments')
@section('page-title', 'Comments')

@section('content')
    <div class="space-y-6" x-data="{ selectedComments: [] }">
        <!-- Header with Bulk Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Comments</h1>
                <p class="mt-1 text-sm text-slate-600">Manage user comments and feedback</p>
            </div>

            <!-- Bulk Actions -->
            <!-- Bulk Actions -->
            <div x-show="selectedComments.length > 0" x-cloak
                class="flex items-center gap-3 bg-blue-50 border border-blue-200 rounded-lg px-4 py-2">
                <span class="text-sm font-medium text-slate-700">
                    <span x-text="selectedComments.length"></span> selected
                </span>

                <form method="POST" action="{{ route('admin:comment:bulk-update') }}" class="flex gap-2" x-ref="bulkForm">
                    @csrf
                    <template x-for="id in selectedComments" :key="id">
                        <input type="hidden" name="comment_ids[]" :value="id">
                    </template>
                    <input type="hidden" name="action" x-ref="bulkAction">

                    <button type="button" @click="$refs.bulkAction.value = 'approve'; $refs.bulkForm.submit()"
                        class="text-sm px-3 py-1 bg-emerald-600 text-white rounded-md hover:bg-emerald-500 transition">
                        Approve
                    </button>
                    <button type="button" @click="$refs.bulkAction.value = 'reject'; $refs.bulkForm.submit()"
                        class="text-sm px-3 py-1 bg-amber-600 text-white rounded-md hover:bg-amber-500 transition">
                        Reject
                    </button>
                    <button type="button"
                        @click="if(confirm('Delete ' + selectedComments.length + ' comment(s)?')) { $refs.bulkAction.value = 'delete'; $refs.bulkForm.submit(); }"
                        class="text-sm px-3 py-1 bg-rose-600 text-white rounded-md hover:bg-rose-500 transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="admin-card p-6">
            <form method="GET" action="{{ route('admin:comment:list') }}"
                class="space-y-4 sm:space-y-0 sm:flex sm:items-end sm:gap-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-slate-700 mb-2">Search</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Search by content, name, or email..." class="admin-form-input">
                </div>

                <div class="sm:w-40">
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                    <select id="status" name="status" class="admin-form-input">
                        <option value="">All Status</option>
                        <option value="active" @selected(request('status') === 'active')>Active</option>
                        <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                    </select>
                </div>

                <div class="sm:w-48">
                    <label for="post" class="block text-sm font-medium text-slate-700 mb-2">Post</label>
                    <select id="post" name="post" class="admin-form-input">
                        <option value="">All Posts</option>
                        @foreach ($posts ?? [] as $post)
                            <option value="{{ $post->id }}" @selected(request('post') == $post->id)>
                                {{ Str::limit($post->title, 40) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <x-admin.button type="submit" variant="outline">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </x-admin.button>

                    @if (request()->hasAny(['search', 'status', 'post']))
                        <x-admin.button href="{{ route('admin:comment:list') }}" variant="outline">
                            Clear
                        </x-admin.button>
                    @endif
                </div>
            </form>
        </div>

        <!-- Stats Cards (Optional) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="admin-card p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Total</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="admin-card p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-emerald-100 rounded-lg">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Active</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $stats['active'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="admin-card p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-amber-100 rounded-lg">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Pending</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $stats['pending'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="admin-card p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-rose-100 rounded-lg">
                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Spam</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $stats['spam'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comments Table -->
        <x-admin.table :headers="['', 'Comment', 'Author', 'Post', 'Status', 'Date', 'Actions']">
            @forelse($comments ?? [] as $comment)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="checkbox" :value="{{ $comment->id }}" x-model="selectedComments"
                            class="admin-checkbox">
                    </td>
                    <td class="px-6 py-4">
                        <div class="max-w-md">
                            <p class="text-sm text-slate-900 line-clamp-2">
                                {{ Str::limit($comment->content, 120) }}
                            </p>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm">
                            <div class="font-medium text-slate-900">{{ $comment->name }}</div>
                            <div class="text-slate-500">{{ $comment->email }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($comment->post)
                            <a href="{{ route('admin:post:show', $comment->post) }}"
                                class="text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors">
                                {{ Str::limit($comment->post->title, 30) }}
                            </a>
                        @else
                            <span class="text-sm text-slate-400">Post deleted</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($comment->is_spam)
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Spam
                            </span>
                        @elseif($comment->is_active)
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Active
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Pending
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                        <div class="flex flex-col">
                            <span>{{ $comment->created_at->format('M j, Y') }}</span>
                            <span class="text-xs text-slate-400">{{ $comment->created_at->format('g:i A') }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end gap-2">
                            <x-admin.button href="{{ route('admin:comment:show', $comment) }}" variant="outline"
                                size="sm" title="View details">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </x-admin.button>

                            @if (!$comment->is_spam)
                                @if ($comment->is_active)
                                    <form method="POST" action="{{ route('admin:comment:reject', $comment) }}"
                                        class="inline">
                                        @csrf
                                        <x-admin.button type="submit" variant="warning" size="sm" title="Reject">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                                </path>
                                            </svg>
                                        </x-admin.button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin:comment:approve', $comment) }}"
                                        class="inline">
                                        @csrf
                                        <x-admin.button type="submit" variant="success" size="sm" title="Approve">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </x-admin.button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('admin:comment:spam', $comment) }}"
                                    class="inline">
                                    @csrf
                                    <x-admin.button type="submit" variant="outline" size="sm" title="Mark as spam"
                                        onclick="return confirm('Mark this comment as spam?')">
                                        <svg class="w-4 h-4 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </x-admin.button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('admin:comment:destroy', $comment) }}" class="inline"
                                onsubmit="return confirm('Delete this comment permanently?')">
                                @csrf
                                @method('DELETE')
                                <x-admin.button type="submit" variant="danger" size="sm" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </x-admin.button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="text-slate-500">
                            <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-slate-900">No comments found</h3>
                            <p class="mt-1 text-sm text-slate-500">Comments will appear here when users interact with your
                                posts.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-admin.table>

        <!-- Pagination -->
        @if (isset($comments) && $comments->hasPages())
            <div class="admin-card px-4 py-3 border-t border-slate-200/70 sm:px-6">
                {{ $comments->links() }}
            </div>
        @endif
    </div>
@endsection

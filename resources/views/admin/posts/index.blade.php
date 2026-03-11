@extends('layouts.admin')

@section('title', 'Posts')
@section('page-title', 'Posts')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Blog Posts</h1>
                <p class="mt-1 text-sm text-slate-600">All journal articles on VagaRetreat.</p>
            </div>
            <x-admin.button :href="route('admin.posts.create')" variant="primary">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Post
            </x-admin.button>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Post</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Author</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Categories</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Published</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($posts as $post)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.posts.show', $post) }}" class="text-sm font-medium text-slate-900 hover:text-blue-600 transition">{{ Str::limit($post->title, 50) }}</a>
                                        <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ Str::limit($post->excerpt, 60) }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $post->author?->name ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($post->categories as $category)
                                            <span class="inline-flex px-2 py-0.5 rounded-full bg-purple-50 text-[10px] font-medium text-purple-600">{{ $category->name }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}
                                    @if($post->is_active || $post->is_published)
                                        <span class="inline-block ml-2 w-2 h-2 rounded-full bg-green-500"></span>
                                    @else
                                        <span class="inline-block ml-2 w-2 h-2 rounded-full bg-slate-300"></span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.posts.show', $post) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">View</a>
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">Edit</a>
                                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-slate-900 mb-1">No Posts</h3>
                                        <p class="text-sm text-slate-500">Blog posts will appear here once published.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($posts->hasPages())
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 px-4 py-3">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection

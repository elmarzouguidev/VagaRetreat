@extends('layouts.admin')

@section('title', $post->title)
@section('page-title', 'Post Details')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <x-admin.button :href="route('admin.posts.index')" variant="outline">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Posts
        </x-admin.button>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                @if($post->getFirstMediaUrl('cms_post_images'))
                    <div class="mb-6 aspect-video rounded-lg overflow-hidden">
                        <img src="{{ $post->getFirstMediaUrl('cms_post_images') }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <h1 class="text-2xl font-bold text-slate-900 mb-2">{{ $post->title }}</h1>
                <p class="text-sm text-slate-500 mb-6">by {{ $post->author?->name ?? 'Unknown' }} · {{ $post->created_at->format('M d, Y') }}</p>

                @if($post->excerpt)
                    <div class="mb-6 p-4 bg-slate-50 rounded-lg italic text-sm text-slate-600 border-l-4 border-blue-500">
                        {{ $post->excerpt }}
                    </div>
                @endif

                <div class="prose prose-sm max-w-none text-slate-700">
                    {!! $post->body !!}
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900">Details</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Slug</label>
                            <p class="text-sm text-slate-600 font-mono bg-slate-50 px-3 py-2 rounded-lg">{{ $post->slug }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Categories</label>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @foreach($post->categories as $category)
                                    <span class="px-3 py-1 rounded-full bg-purple-50 text-xs font-medium text-purple-600">{{ $category->name }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Public Link</label>
                            <a href="{{ route('blog.show', $post) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">View on Site →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

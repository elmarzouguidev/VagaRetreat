@extends('layouts.admin')

@section('title', $page->title)
@section('page-title', 'Page Details')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <x-admin.button :href="route('admin.pages.index')" variant="outline">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Pages
        </x-admin.button>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                @if($page->getFirstMediaUrl('cms_page_images'))
                    <div class="mb-6 aspect-[21/9] rounded-lg overflow-hidden">
                        <img src="{{ $page->getFirstMediaUrl('cms_page_images') }}" alt="{{ $page->title }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <h1 class="text-2xl font-bold text-slate-900 mb-2">{{ $page->title }}</h1>
                <p class="text-sm text-slate-500 mb-6">{{ $page->created_at->format('M d, Y') }}</p>

                @if($page->excerpt)
                    <div class="mb-6 p-4 bg-slate-50 rounded-lg italic text-sm text-slate-600 border-l-4 border-blue-500">
                        {{ $page->excerpt }}
                    </div>
                @endif

                <div class="prose prose-sm max-w-none text-slate-700">
                    {!! $page->body !!}
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900">Details</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Slug</label>
                        <p class="text-sm text-slate-600 font-mono bg-slate-50 px-3 py-2 rounded-lg">{{ $page->slug }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Public Link</label>
                        <a href="{{ route('cms.pages.show', $page) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">View on Site →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

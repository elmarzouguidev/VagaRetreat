<x-app-layout>
    <div class="bg-white min-h-screen pb-20">
        <!-- Hero Section/Header -->
        <div class="bg-gray-50 py-20 border-b border-gray-100 mb-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    @if($post->categories->isNotEmpty())
                        <div class="flex justify-center flex-wrap gap-2 mb-8">
                            @foreach($post->categories as $category)
                                <span class="bg-elmarzouguidev-vaga-red text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-sm">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <h1 class="text-4xl md:text-5xl font-black text-gray-900 leading-tight mb-8">
                        {{ $post->title }}
                    </h1>

                    <div class="flex items-center justify-center space-x-4 text-sm font-bold text-gray-400 uppercase tracking-widest">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-gray-200 mr-3 flex items-center justify-center text-gray-500">
                                {{ substr($post->author->name ?? 'V', 0, 1) }}
                            </div>
                            <span class="text-gray-900">{{ $post->author->name ?? 'VagaRetreat Team' }}</span>
                        </div>
                        <span>•</span>
                        <span>{{ $post->published_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Article Content -->
        <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Featured Image -->
            <div class="mb-16 aspect-video rounded-3xl overflow-hidden shadow-2xl">
                <img src="{{ $post->getFirstMediaUrl('cms_post_images') ?: 'https://images.unsplash.com/photo-1432821596592-e2c18b78144f?auto=format&fit=crop&q=80&w=1200' }}" 
                     alt="{{ $post->title }}"
                     class="w-full h-full object-cover">
            </div>

            <div class="max-w-3xl mx-auto">
                <!-- Excerpt/Intro -->
                <div class="text-xl text-gray-600 leading-relaxed font-medium mb-12 italic border-l-4 border-elmarzouguidev-vaga-red pl-8">
                    {{ $post->excerpt }}
                </div>

            <!-- Body Content -->
            <div class="prose prose-lg max-w-none text-gray-800 leading-read tracking-tight">
                {!! nl2br(e($post->body)) !!}
            </div>

            <!-- Footer / Back to Blog -->
            <div class="mt-20 pt-12 border-t border-gray-100 flex justify-center">
                <a href="{{ route('blog.index') }}" class="inline-flex items-center text-xs font-black text-gray-900 uppercase tracking-widest bg-gray-100 px-8 py-4 rounded-xl hover:bg-elmarzouguidev-vaga-red hover:text-white transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path></svg>
                    Back to Journal
                </a>
            </div>
        </article>
    </div>
</x-app-layout>

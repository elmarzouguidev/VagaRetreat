<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-16">
                <h1 class="text-4xl font-black text-gray-900 uppercase tracking-tighter mb-4">VagaRetreat Journal</h1>
                <div class="w-20 h-1 bg-elmarzouguidev-vaga-red mx-auto"></div>
                <p class="mt-6 text-xl text-gray-600 max-w-2xl mx-auto">Stories, guides, and inspiration for your next
                    mindful adventure.</p>
            </div>

            <!-- Posts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($posts as $post)
                    <article
                        class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 group">
                        <!-- Post Image -->
                        <div class="aspect-video bg-gray-100 relative overflow-hidden">
                            <img src="{{ $post->getFirstMediaUrl('cms_post_images') ?: 'https://images.unsplash.com/photo-1432821596592-e2c18b78144f?auto=format&fit=crop&q=80&w=800' }}"
                                alt="{{ $post->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                            @if ($post->categories->isNotEmpty())
                                <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                                    @foreach ($post->categories as $category)
                                        <span
                                            class="bg-elmarzouguidev-vaga-red text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="p-8">
                            <div
                                class="flex items-center text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">
                                <span>{{ $post->published_at->format('M d, Y') }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $post->author->name ?? 'VagaRetreat' }}</span>
                            </div>

                            <h2
                                class="text-xl font-black text-gray-900 mb-4 group-hover:text-elmarzouguidev-vaga-red transition-colors duration-300 leading-tight">
                                <a href="{{ route('blog.show', $post) }}">
                                    {{ $post->title }}
                                </a>
                            </h2>

                            <p class="text-gray-600 text-sm leading-relaxed mb-8 line-clamp-3">
                                {{ $post->excerpt }}
                            </p>

                            <a href="{{ route('blog.show', $post) }}"
                                class="inline-flex items-center text-xs font-black text-gray-900 uppercase tracking-widest border-b-2 border-elmarzouguidev-vaga-red pb-1 hover:text-elmarzouguidev-vaga-red transition-all">
                                Read Story
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-16">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="bg-white min-h-screen py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <header class="mb-16">
                <!-- Page Featured Image -->
                <div class="mb-12 aspect-[21/9] rounded-3xl overflow-hidden shadow-xl">
                    <img src="{{ $page->getFirstMediaUrl('cms_page_images') ?: 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&q=80&w=1200' }}" 
                         alt="{{ $page->title }}"
                         class="w-full h-full object-cover">
                </div>

                <h1 class="text-4xl md:text-5xl font-black text-gray-900 leading-tight mb-8">
                    {{ $page->title }}
                </h1>
                
                @if($page->excerpt)
                    <p class="text-xl text-gray-500 leading-relaxed font-medium italic border-l-4 border-elmarzouguidev-vaga-red pl-8">
                        {{ $page->excerpt }}
                    </p>
                @endif
                
                <div class="w-20 h-1 bg-elmarzouguidev-vaga-red mt-12"></div>
            </header>

            <!-- Page Content -->
            <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
                {!! $page->body !!}
            </div>

            <!-- Footer Meta -->
            <div class="mt-20 pt-8 border-t border-gray-100 flex items-center justify-between">
                <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                    Last updated: {{ $page->updated_at->format('F d, Y') }}
                </div>
                
                <a href="{{ route('home') }}" class="text-xs font-black text-gray-900 uppercase tracking-widest hover:text-elmarzouguidev-vaga-red transition-all border-b-2 border-transparent hover:border-elmarzouguidev-vaga-red pb-1">
                    Return to Home
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

@props(['tour'])

<div
    class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300 flex flex-col h-full group">
    <!-- Image -->
    <div class="relative h-48 overflow-hidden">
        <img src="{{ $tour->thumbnail ?? 'https://images.unsplash.com/photo-15422596594ab-d7fe17d985a6?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80' }}"
            alt="{{ $tour->title }}"
            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">

        <!-- Badge (e.g., Best Seller, New) -->
        @if ($tour->is_featured)
            <div class="absolute top-4 left-4">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white text-elmarzouguidev-vaga-red shadow-sm">
                    Featured
                </span>
            </div>
        @endif

        <!-- Wishlist Button -->
        <button
            class="absolute top-4 right-4 p-2 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                </path>
            </svg>
        </button>
    </div>

    <!-- Content -->
    <div class="p-5 flex-1 flex flex-col">
        <!-- Location & Category -->
        <div class="flex items-center text-xs text-gray-500 mb-2 space-x-2">
            @if ($tour->cities?->isNotEmpty())
                <span class="flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    {{ $tour->cities?->first()?->country?->name ?? 'Unknown' }}
                </span>
            @endif
            <span>&bull;</span>
            <span class="uppercase tracking-wide">
                {{ $tour->categories?->first()?->name ?? 'Adventure' }}
            </span>
        </div>

        <!-- Title -->
        <h3 class="text-lg font-bold text-gray-900 mb-2 leading-tight">
            <a href="{{ route('tours.show', $tour) }}" class="hover:text-elmarzouguidev-vaga-red transition-colors">
                {{ $tour->title }}
            </a>
        </h3>

        <!-- Rating -->
        <div class="flex items-center mb-4">
            <div class="flex items-center text-yellow-400">
                @for ($i = 0; $i < 5; $i++)
                    <svg class="w-4 h-4 {{ $i < 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                        </path>
                    </svg>
                @endfor
            </div>
            <span class="ml-1 text-xs text-gray-500">(24 reviews)</span>
        </div>

        <!-- Instructor/Host -->
        <div class="flex items-center mb-4 pb-4 border-b border-gray-100">
            <img class="h-8 w-8 rounded-full border border-gray-100"
                src="https://ui-avatars.com/api/?name=Instructor+Name&background=random" alt="Instructor">
            <div class="ml-2">
                <p class="text-xs text-gray-500">Hosted by <span class="text-gray-900 font-medium">VagaRetreat
                        Instructor</span></p>
            </div>
        </div>

        <!-- Footer: Price & Duration -->
        <div class="mt-auto flex items-center justify-between">
            <div class="text-xs text-gray-500">
                <span class="block text-gray-900 font-semibold">{{ $tour->duration_days }} Days</span>
                Duration
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500">From</p>
                <p class="text-lg font-bold text-elmarzouguidev-vaga-red">
                    {{ $tour->prices->first()->formatted_price }}
                </p>
            </div>
        </div>
    </div>
</div>

@props(['tour'])

<div class="bg-white rounded-2xl shadow-sm border border-slate-100/50 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full group">
    <!-- Image Header -->
    <div class="relative h-64 overflow-hidden">
        <img src="{{ $tour->thumbnail ?? 'https://images.unsplash.com/photo-15422596594ab-d7fe17d985a6?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80' }}"
             alt="{{ $tour->title }}"
             class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out">
        
        <!-- Subtle darker overlay for text contrast -->
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-80"></div>

        <!-- Badges -->
        <div class="absolute top-4 left-4 flex flex-col gap-2">
            @if ($tour->is_featured)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/90 backdrop-blur-sm shadow-sm text-red-600">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    Featured
                </span>
            @endif
        </div>

        <!-- Wishlist / Heart -->
        <button class="absolute top-4 right-4 p-2.5 rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-md text-white transition-all duration-200" aria-label="Save to wishlist">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
        </button>

        <!-- Location Bottom overlay -->
        <div class="absolute bottom-4 left-4 right-4">
            <div class="flex items-center gap-2 text-white">
                @if ($tour->cities?->isNotEmpty())
                    <span class="flex items-center text-sm font-medium drop-shadow-md">
                        <svg class="w-4 h-4 mr-1 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $tour->cities->first()->country?->name ?? 'Unknown' }}, {{ $tour->cities->first()->name }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Body Content -->
    <div class="p-5 md:p-6 flex-1 flex flex-col">
        <!-- Tags -->
        <div class="flex flex-wrap gap-2 mb-3">
            @foreach($tour->categories->take(2) as $category)
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold tracking-wider uppercase bg-slate-100 text-slate-600">
                    {{ $category->name }}
                </span>
            @endforeach
        </div>

        <!-- Title -->
        <h3 class="text-xl font-bold text-slate-900 mb-2 leading-tight group-hover:text-red-600 transition-colors">
            <a href="{{ route('tours.show', $tour) }}">
                {{ $tour->title }}
                <span class="absolute inset-0 z-10" aria-hidden="true"></span>
            </a>
        </h3>

        <!-- Description Snippet (Optional but nice) -->
        <div class="text-sm text-slate-500 mb-4 line-clamp-2">
            {{ strip_tags($tour->description ?? 'Join us on an unforgettable journey to explore self-discovery and wellness.') }}
        </div>

        <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
            <!-- Duration -->
            <div class="flex items-center gap-2 text-slate-600">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-sm font-medium">{{ $tour->duration_days }} Days</span>
            </div>

            <!-- Price -->
            <div class="text-right flex flex-col">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">From</span>
                <span class="text-xl font-bold tracking-tight text-slate-900">
                    @if($tour->prices->isNotEmpty())
                        {{ $tour->prices->first()->formatted_price }}
                    @else
                        $0.00
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>

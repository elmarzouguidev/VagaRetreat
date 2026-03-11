<x-app-layout>
    <div x-data="{ activeTab: 'overview' }" class="bg-white">
        
        <!-- Premium Hero Section -->
        <div class="relative h-[65vh] min-h-[500px] w-full bg-slate-900 overflow-hidden">
            <!-- Background Image -->
            <img src="{{ $tour->thumbnail ?? 'https://images.unsplash.com/photo-15422596594ab-d7fe17d985a6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80' }}"
                alt="{{ $tour->title }}" class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-overlay">
            
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>

            <div class="absolute bottom-0 left-0 w-full pb-12 pt-32 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <!-- Badges -->
                    <div class="flex flex-wrap gap-3 mb-6">
                        @if ($tour->is_featured)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold leading-5 bg-white/10 backdrop-blur-md text-white border border-white/20 shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-400 mr-2 animate-pulse"></span>
                                Featured Retreat
                            </span>
                        @endif
                        @foreach($tour->categories->take(3) as $category)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold leading-5 bg-white/10 backdrop-blur-md text-white border border-white/20 shadow-sm">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>

                    <!-- Title -->
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 leading-tight tracking-tight drop-shadow-md max-w-4xl">
                        {{ $tour->title }}
                    </h1>

                    <!-- Key Metadata -->
                    <div class="flex flex-wrap items-center text-slate-200 text-sm md:text-base gap-6 md:gap-8 font-medium">
                        @if ($tour->cities?->isNotEmpty())
                        <div class="flex items-center text-white drop-shadow">
                            <svg class="w-5 h-5 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $tour->cities->first()->name }}, {{ $tour->cities->first()?->country?->name ?? 'Global' }}
                        </div>
                        @endif
                        <div class="flex items-center text-white drop-shadow">
                            <svg class="w-5 h-5 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $tour->duration_days }} Days
                        </div>
                        <div class="flex items-center text-white drop-shadow">
                            <div class="flex text-amber-400 mr-2 drop-shadow-sm">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            </div>
                            <span>Excellence Rating</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Layout -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">

                <!-- Left Column: Content -->
                <div class="lg:w-[65%] min-w-0">

                    <!-- Sticky Tabs Navigation -->
                    <div class="border-b border-slate-200 mb-10 sticky top-[72px] bg-white/90 backdrop-blur-md z-30 pt-4">
                        <nav class="-mb-px flex space-x-8 overflow-x-auto scrollbar-hide" aria-label="Tabs">
                            <button @click="activeTab = 'overview'"
                                :class="{ 'border-red-500 text-slate-900 font-bold': activeTab === 'overview', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 font-medium': activeTab !== 'overview' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 text-sm transition-all duration-200">
                                Overview
                            </button>
                            <button @click="activeTab = 'itinerary'"
                                :class="{ 'border-red-500 text-slate-900 font-bold': activeTab === 'itinerary', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 font-medium': activeTab !== 'itinerary' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 text-sm transition-all duration-200">
                                Itinerary
                            </button>
                            <button @click="activeTab = 'accommodation'"
                                :class="{ 'border-red-500 text-slate-900 font-bold': activeTab === 'accommodation', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 font-medium': activeTab !== 'accommodation' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 text-sm transition-all duration-200">
                                Accommodation
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Contents -->

                    <!-- 1. Overview Tab -->
                    <div x-show="activeTab === 'overview'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="prose prose-slate max-w-none prose-p:text-slate-600 prose-p:leading-relaxed prose-headings:text-slate-900">
                        <h2 class="text-3xl font-bold tracking-tight mb-6">About this journey</h2>
                        <div class="text-lg text-slate-700 font-medium leading-relaxed mb-8 border-l-4 border-red-500 pl-6 bg-slate-50/50 py-4 rounded-r-2xl">
                            Join us on an unforgettable {{ $tour->duration_days }}-day transformative experience.
                        </div>
                        <div class="text-slate-600 leading-loose">
                            {!! $tour->description !!}
                        </div>

                        <hr class="my-12 border-slate-100">

                        <h3 class="text-2xl font-bold tracking-tight mb-6">Experience Highlights</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8">
                            <div class="flex items-start">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-50 text-emerald-500 mr-4 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </span>
                                <span class="text-slate-700 font-medium py-1">Intimate group sizes</span>
                            </div>
                            <div class="flex items-start">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-50 text-emerald-500 mr-4 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </span>
                                <span class="text-slate-700 font-medium py-1">Expert local guides</span>
                            </div>
                            <div class="flex items-start">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-50 text-emerald-500 mr-4 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </span>
                                <span class="text-slate-700 font-medium py-1">Curated premium accommodations</span>
                            </div>
                            <div class="flex items-start">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-50 text-emerald-500 mr-4 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </span>
                                <span class="text-slate-700 font-medium py-1">Transformative sessions</span>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Itinerary Tab -->
                    <div x-show="activeTab === 'itinerary'" x-cloak x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Daily Itinerary</h2>
                            <span class="text-sm font-medium text-slate-500 bg-slate-100 px-3 py-1 rounded-full">{{ $tour->plans->count() }} Days Planned</span>
                        </div>
                        
                        @if($tour->plans->isNotEmpty())
                            <div class="relative border-l-2 border-slate-200 ml-4 space-y-12 pb-8">
                                @foreach($tour->plans as $plan)
                                    <div class="relative pl-8 group">
                                        <!-- Timeline dot -->
                                        <div class="absolute -left-[11px] top-1 w-5 h-5 rounded-full bg-white border-4 border-slate-200 group-hover:border-red-500 transition-colors duration-300"></div>
                                        
                                        <div class="flex flex-col md:flex-row md:items-baseline gap-2 md:gap-4 mb-3">
                                            <h3 class="text-xl font-bold text-slate-900 group-hover:text-red-600 transition-colors">Day {{ $plan->day_number }}</h3>
                                            <span class="text-lg font-medium text-slate-700">{{ $plan->title }}</span>
                                        </div>
                                        
                                        <div class="bg-slate-50/80 rounded-2xl p-6 border border-slate-100">
                                            <div class="prose prose-sm max-w-none text-slate-600">
                                                {!! $plan->description !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-slate-50 rounded-2xl p-12 text-center border border-slate-100">
                                <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <h3 class="text-lg font-bold text-slate-900 mb-2">Itinerary in Development</h3>
                                <p class="text-slate-500 max-w-sm mx-auto">We are carefully crafting the daily schedule for this retreat. Check back soon for full details.</p>
                            </div>
                        @endif
                    </div>

                    <!-- 3. Accommodation Tab -->
                    <div x-show="activeTab === 'accommodation'" x-cloak x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                        <h2 class="text-3xl font-bold text-slate-900 tracking-tight mb-8">Sanctuaries of Rest</h2>
                        
                        @if ($tour->accommodations?->isNotEmpty())
                            <div class="space-y-8">
                                @foreach ($tour->accommodations as $accom)
                                    <div class="flex flex-col xl:flex-row bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                        <!-- Slider Wrapper -->
                                        <div class="xl:w-2/5 relative bg-slate-100 min-h-[250px] xl:min-h-full" 
                                             x-data="{ 
                                                currentSlide: 0, 
                                                slidesCount: {{ $accom->media->count() > 0 ? $accom->media->count() : 1 }},
                                                next() { this.currentSlide = (this.currentSlide + 1) % this.slidesCount },
                                                prev() { this.currentSlide = (this.currentSlide - 1 + this.slidesCount) % this.slidesCount }
                                             }">
                                             
                                            <div class="absolute inset-0 w-full h-full">
                                                @forelse($accom->getMedia('accommodation_images') as $index => $media)
                                                    <div x-show="currentSlide === {{ $index }}" 
                                                         x-transition:enter="transition ease-out duration-500"
                                                         x-transition:enter-start="opacity-0"
                                                         x-transition:enter-end="opacity-100"
                                                         x-transition:leave="transition ease-in duration-300"
                                                         x-transition:leave-start="opacity-100"
                                                         x-transition:leave-end="opacity-0"
                                                         class="absolute inset-0 w-full h-full">
                                                        <img src="{{ $media->getUrl() }}" alt="{{ $accom->name }}" class="w-full h-full object-cover">
                                                    </div>
                                                @empty
                                                    <div class="absolute inset-0 w-full h-full">
                                                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                                                            alt="{{ $accom->name }}" class="w-full h-full object-cover">
                                                    </div>
                                                @endforelse
                                            </div>

                                            @if($accom->getMedia('accommodation_images')->count() > 1)
                                                <!-- Overlay Gradients -->
                                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 via-transparent to-transparent pointer-events-none"></div>

                                                <!-- Navigation Arrows -->
                                                <button @click="prev()" class="absolute left-3 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center bg-white/20 hover:bg-white/40 backdrop-blur text-white rounded-full transition-all z-10 hover:scale-110">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                                                </button>
                                                <button @click="next()" class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center bg-white/20 hover:bg-white/40 backdrop-blur text-white rounded-full transition-all z-10 hover:scale-110">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                                </button>

                                                <!-- Indicators -->
                                                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-1.5 z-10">
                                                    @foreach($accom->getMedia('accommodation_images') as $index => $media)
                                                        <button @click="currentSlide = {{ $index }}" 
                                                                :class="currentSlide === {{ $index }} ? 'bg-white w-4' : 'bg-white/50 w-2 hover:bg-white/80'"
                                                                class="h-2 rounded-full transition-all duration-300 shadow-sm"></button>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="p-8 xl:w-3/5 flex flex-col justify-center">
                                            <div class="flex justify-between items-start mb-4">
                                                <div>
                                                    <h3 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $accom->name }}</h3>
                                                    <p class="text-sm font-medium text-slate-500 mt-1 uppercase tracking-wider">{{ $accom->type->label() }} &bull; Max {{ $accom->capacity }} Adults</p>
                                                </div>
                                                
                                                @if($accom->prices->isNotEmpty())
                                                    <div class="text-right">
                                                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Upgrade Options From</span>
                                                        <span class="text-xl font-bold text-slate-900 bg-emerald-50 text-emerald-700 px-3 py-1 rounded-xl block border border-emerald-100">+{{ $accom->prices->first()->formatted_price }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="prose prose-sm text-slate-600 leading-relaxed mb-6">
                                                {!! $accom->description ?? '<p>Comfortable and spacious accommodation designed for ultimate relaxation.</p>' !!}
                                            </div>
                                            
                                            @if($accom->amenities->isNotEmpty())
                                            <div class="mt-auto pt-4 border-t border-slate-100">
                                                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-3">Included Amenities</h4>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($accom->amenities as $amenity)
                                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-50 text-slate-700 border border-slate-200 shadow-sm hover:shadow hover:-translate-y-0.5 transition-all">
                                                            @if($amenity->icon)
                                                                <span class="mr-2 text-slate-400">
                                                                    {!! $amenity->icon !!}
                                                                </span>
                                                            @else
                                                                <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                            @endif
                                                            {{ $amenity->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-slate-50 rounded-2xl p-12 text-center border border-slate-100">
                                <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                <h3 class="text-lg font-bold text-slate-900 mb-2">Accommodation details pending</h3>
                                <p class="text-slate-500 max-w-sm mx-auto">We are currently finalizing our local property partnerships for this retreat.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Sticky Booking Sidebar -->
                <div class="lg:w-[35%]">
                    <div class="sticky top-28">
                        <div class="bg-white rounded-3xl shadow-2xl shadow-slate-200/50 overflow-hidden border border-slate-200">
                            <!-- Pricing Header -->
                            <div class="bg-slate-900 p-8 text-white relative overflow-hidden">
                                <!-- Abstract decorative shape -->
                                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white/5 blur-2xl"></div>
                                <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 rounded-full bg-red-500/20 blur-xl"></div>
                                
                                <div class="relative z-10 flex justify-between items-end pb-2">
                                    <span class="text-sm font-medium text-slate-400 tracking-wider uppercase">Starting From</span>
                                    @if ($tour->prices->isNotEmpty())
                                        <div class="text-right">
                                            <span class="text-4xl font-extrabold tracking-tight text-white mb-1 block">
                                                {{ $tour->prices->first()->formatted_price }}
                                            </span>
                                            <span class="text-xs font-bold text-red-400 uppercase tracking-widest bg-red-400/10 px-2 py-1 rounded inline-block">
                                                {{ $tour->prices->first()->name ?? 'Base Package' }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-3xl font-extrabold text-white">Contact Us</span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Booking Body -->
                            <div class="p-8">
                                <div class="space-y-5 mb-8">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center border border-blue-100 mt-0.5">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div class="ml-4">
                                            <span class="block font-bold text-slate-900">Flexible Scheduling</span>
                                            <span class="text-sm text-slate-500">Subject to live availability</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center border border-emerald-100 mt-0.5">
                                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <div class="ml-4">
                                            <span class="block font-bold text-slate-900">Intimate Experience</span>
                                            <span class="text-sm text-slate-500">Maximum capacity strictly enforced</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center border border-purple-100 mt-0.5">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                        </div>
                                        <div class="ml-4">
                                            <span class="block font-bold text-slate-900">Guaranteed Protection</span>
                                            <span class="text-sm text-slate-500">100% Secure global payment processing</span>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('bookings.create', $tour) }}"
                                    class="relative group w-full flex items-center justify-center bg-red-600 text-white font-bold py-4 px-6 rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-lg hover:shadow-red-600/30 transform hover:-translate-y-0.5 border border-red-500">
                                    <span class="absolute w-0 h-0 transition-all duration-500 ease-out bg-white rounded-full group-hover:w-full group-hover:h-56 opacity-10"></span>
                                    <span class="relative text-lg tracking-wide uppercase">Request to Book</span>
                                </a>

                                <p class="text-xs text-center font-medium text-slate-400 mt-5">
                                    <span class="block mb-1 text-slate-900">You won't be charged yet.</span>
                                    Your booking request will be confirmed by our team.
                                </p>
                            </div>
                            
                            <!-- Notice Footer -->
                            <div class="bg-slate-50/80 px-8 py-5 border-t border-slate-100 flex items-start gap-3">
                                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-sm font-medium text-slate-700 leading-snug">Relax with our flexible cancellation policy up to 30 days before the retreat begins.</span>
                            </div>
                        </div>

                        <div class="mt-8 text-center flex items-center justify-center gap-2 group">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center group-hover:bg-slate-200 transition-colors">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <a href="{{ route('contact.index') }}" class="text-sm font-bold text-slate-900 hover:text-red-600 transition-colors underline decoration-slate-300 underline-offset-4 decoration-2">Have a question? Ask the Host</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div x-data="{ activeTab: 'overview' }">
        <!-- Hero Section -->
        <div class="relative h-[60vh] bg-gray-900">
            <img src="{{ $tour->thumbnail ?? 'https://images.unsplash.com/photo-15422596594ab-d7fe17d985a6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80' }}"
                alt="{{ $tour->title }}" class="w-full h-full object-cover opacity-70">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>

            <div class="absolute bottom-0 left-0 w-full p-8 md:p-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @if ($tour->is_featured)
                        <span
                            class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-elmarzouguidev-vaga-red text-white mb-4">
                            Featured Retreat
                        </span>
                    @endif
                    <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 leading-tight">{{ $tour->title }}
                    </h1>

                    <div
                        class="flex flex-wrap items-center text-white text-sm md:text-base space-y-2 md:space-y-0 md:space-x-8">
                        <div class="flex items-center mr-6">
                            <svg class="w-5 h-5 mr-2 text-elmarzouguidev-vaga-red" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $tour->cities->first()?->country?->name ?? 'Various Locations' }}
                        </div>
                        <div class="flex items-center mr-6">
                            <svg class="w-5 h-5 mr-2 text-elmarzouguidev-vaga-red" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $tour->duration_days }} Days
                        </div>
                        <div class="flex items-center">
                            <div class="flex text-yellow-400 mr-2">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                @endfor
                            </div>
                            <span>(24 Reviews)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Layout -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col lg:flex-row gap-12">

                <!-- Left Column: Content -->
                <div class="lg:w-2/3">

                    <!-- Tabs Navigation -->
                    <div class="border-b border-gray-200 mb-8 sticky top-0 bg-white z-10">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <button @click="activeTab = 'overview'"
                                :class="{ 'border-elmarzouguidev-vaga-red text-elmarzouguidev-vaga-red': activeTab === 'overview', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'overview' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Overview
                            </button>
                            <button @click="activeTab = 'itinerary'"
                                :class="{ 'border-elmarzouguidev-vaga-red text-elmarzouguidev-vaga-red': activeTab === 'itinerary', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'itinerary' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Itinerary
                            </button>
                            <button @click="activeTab = 'accommodation'"
                                :class="{ 'border-elmarzouguidev-vaga-red text-elmarzouguidev-vaga-red': activeTab === 'accommodation', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'accommodation' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Accommodation
                            </button>
                            <button @click="activeTab = 'instructor'"
                                :class="{ 'border-elmarzouguidev-vaga-red text-elmarzouguidev-vaga-red': activeTab === 'instructor', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'instructor' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Instructor
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Contents -->

                    <!-- Overview Tab -->
                    <div x-show="activeTab === 'overview'" class="prose max-w-none text-gray-600">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">About this trip</h2>
                        <p class="mb-6 leading-relaxed">
                            {{ $tour->description }}
                        </p>

                        <h3 class="text-xl font-bold text-gray-900 mb-3">Highlights</h3>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-2 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Small group sizes (max 12)</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-2 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Expert local guides</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-2 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>All meals included</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-2 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Premium accommodation</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Itinerary Tab (Placeholder) -->
                    <div x-show="activeTab === 'itinerary'" style="display: none;">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Daily Itinerary</h2>
                        <div class="border-l-2 border-gray-200 ml-4 space-y-12">
                            <!-- Day 1 -->
                            <div class="relative pl-8">
                                <div
                                    class="absolute -left-2.5 top-0 w-5 h-5 rounded-full bg-elmarzouguidev-vaga-red border-4 border-white">
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Day 1: Arrival & Welcome Dinner</h3>
                                <p class="mt-2 text-gray-600">Arrive at the destination and transfer to your hotel.
                                    Meet your instructor and fellow travelers for a welcome dinner.</p>
                            </div>
                            <!-- Day 2 -->
                            <div class="relative pl-8">
                                <div
                                    class="absolute -left-2.5 top-0 w-5 h-5 rounded-full bg-gray-300 border-4 border-white">
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Day 2: Morning Session & Exploration</h3>
                                <p class="mt-2 text-gray-600">Start the day with a morning yoga session followed by a
                                    guided tour of the local area.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Accommodation Tab -->
                    <div x-show="activeTab === 'accommodation'" style="display: none;">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Where you'll stay</h2>
                        @if ($tour->accommodations?->isNotEmpty())
                            <div class="grid grid-cols-1 gap-6">
                                @foreach ($tour->accommodations as $accom)
                                    <div
                                        class="flex flex-col md:flex-row bg-white rounded-lg border border-gray-200 overflow-hidden">
                                        <div class="md:w-1/3 bg-gray-100 min-h-[200px] relative overflow-hidden" 
                                             x-data="{ 
                                                currentSlide: 0, 
                                                slidesCount: {{ $accom->media->count() }},
                                                next() { this.currentSlide = (this.currentSlide + 1) % this.slidesCount },
                                                prev() { this.currentSlide = (this.currentSlide - 1 + this.slidesCount) % this.slidesCount }
                                             }">
                                            <!-- Slider Wrapper -->
                                            <div class="relative w-full h-full min-h-[200px]">
                                                @forelse($accom->getMedia('accommodation_images') as $index => $media)
                                                    <div x-show="currentSlide === {{ $index }}" 
                                                         x-transition:enter="transition ease-out duration-300"
                                                         x-transition:enter-start="opacity-0 transform scale-95"
                                                         x-transition:enter-end="opacity-100 transform scale-100"
                                                         class="absolute inset-0 w-full h-full">
                                                        <img src="{{ $media->getUrl() }}" alt="{{ $accom->name }}" class="w-full h-full object-cover">
                                                    </div>
                                                @empty
                                                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                                                        alt="{{ $accom->name }}" class="w-full h-full object-cover">
                                                @endforelse
                                            </div>

                                            <!-- Navigation Arrows -->
                                            @if($accom->getMedia('accommodation_images')->count() > 1)
                                                <button @click="prev()" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white rounded-full p-1 transition-colors z-10">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                                </button>
                                                <button @click="next()" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white rounded-full p-1 transition-colors z-10">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                </button>

                                                <!-- Indicators -->
                                                <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex space-x-1 z-10">
                                                    @foreach($accom->getMedia('accommodation_images') as $index => $media)
                                                        <button @click="currentSlide = {{ $index }}" 
                                                                :class="currentSlide === {{ $index }} ? 'bg-white w-3' : 'bg-white/50 w-1.5'"
                                                                class="h-1.5 rounded-full transition-all duration-300"></button>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-6 md:w-2/3">
                                            <h3 class="text-xl font-bold text-gray-900">{{ $accom->name }}</h3>
                                            <p class="text-sm text-gray-500 mb-4">{{ $accom->quantity }} rooms
                                                available</p>
                                            <p class="text-gray-600 mb-4">
                                                {{ $accom->description ?? 'Comfortable and spacious accommodation designed for relaxation.' }}
                                            </p>
                                            
                                            <!-- Amenities -->
                                            @if($accom->amenities->isNotEmpty())
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($accom->amenities as $amenity)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        @if($amenity->icon)
                                                            <i class="fas fa-{{ $amenity->icon }} mr-1"></i>
                                                        @endif
                                                        {{ $amenity->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Accommodation details coming soon.</p>
                        @endif
                    </div>

                    <!-- Instructor Tab -->
                    <div x-show="activeTab === 'instructor'" style="display: none;">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Meet your Instructor</h2>
                        <div
                            class="bg-gray-50 rounded-lg p-8 flex flex-col md:flex-row items-center md:items-start text-center md:text-left">
                            <img class="h-32 w-32 rounded-full border-4 border-white shadow-lg mb-6 md:mb-0 md:mr-8"
                                src="https://ui-avatars.com/api/?name=Instructor+Name&size=200" alt="Instructor">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Expert Instructor</h3>
                                <p class="text-elmarzouguidev-vaga-red font-medium mb-4">Yoga & Meditation Expert</p>
                                <p class="text-gray-600 mb-4">
                                    With over 10 years of experience leading retreats around the world, our instructor
                                    brings a wealth of knowledge and passion to every trip.
                                </p>
                                <div class="flex justify-center md:justify-start space-x-4">
                                    <a href="#" class="text-gray-400 hover:text-elmarzouguidev-vaga-red"><span
                                            class="sr-only">Instagram</span><svg class="h-6 w-6" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M12 2.163c3.204 0 3.584.012 4.85.072 3.269.156 5.023 1.938 5.154 5.155.06 1.265.071 1.646.071 4.85 0 3.204-.011 3.584-.072 4.85-.156 3.269-1.938 5.023-5.155 5.154-1.265.06-1.646.071-4.85.071-3.204 0-3.584-.011-4.85-.072-3.269-.156-5.023-1.938-5.154-5.155C2.175 15.647 2.163 15.266 2.163 12.061c0-3.204.012-3.584.072-4.85C2.396 3.941 4.18 2.18 7.396 2.054c1.265-.06 1.645-.071 4.849-.071l.755.035zm-7.975 7.975h2.38v2.38h-2.38v-2.38zm7.975-5.595a5.596 5.596 0 100 11.192 5.596 5.596 0 000-11.192zm0 8.812a3.217 3.217 0 110-6.434 3.217 3.217 0 010 6.434z" />
                                        </svg></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Booking Sidebar -->
                <div class="lg:w-1/3">
                    <div class="sticky top-24">
                        <div class="bg-white rounded-lg shadow-xl overflow-hidden border border-gray-100">
                            <div class="p-6">
                                <div class="flex justify-between items-baseline mb-4">
                                    <span class="text-sm text-gray-500">Starting from</span>
                                    @foreach ($tour->prices as $price)
                                        <span class="text-2xl font-bold text-elmarzouguidev-vaga-red">
                                            {{ $price->formatted_price }}
                                            <span class="text-sm text-gray-800">{{ $price->name ?? '' }}</span>
                                        </span>
                                        
                                    @endforeach
                                </div>

                                <div class="space-y-4 mb-6">
                                    <div class="flex items-center text-sm text-gray-600 py-3 border-b border-gray-100">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="font-medium text-gray-900">Multiple Dates Available</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600 py-3 border-b border-gray-100">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                        <span class="font-medium text-gray-900">Max 12 People</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600 py-3 border-b border-gray-100">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                            </path>
                                        </svg>
                                        <span class="font-medium text-gray-900">Secure Payment</span>
                                    </div>
                                </div>

                                <a href="{{ route('bookings.create', $tour) }}"
                                    class="w-full bg-elmarzouguidev-vaga-red text-white font-bold py-4 px-6 rounded-md hover:bg-elmarzouguidev-vaga-red-dark transition-colors duration-200 shadow-md text-lg block text-center">
                                    Check Availability
                                </a>

                                <p class="text-xs text-center text-gray-500 mt-4">
                                    No credit card required to enable booking
                                </p>
                            </div>
                            <div
                                class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-900">Free cancellation up to 7 days</span>
                            </div>
                        </div>

                        <div class="mt-6 text-center">
                            <a href="#" class="text-sm text-gray-500 hover:text-gray-900 underline">Ask a
                                question to the host</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

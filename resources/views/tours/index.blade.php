<x-app-layout>
    <!-- Hero Section -->
    <div class="relative bg-slate-900 overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&q=80&w=2000" class="w-full h-full object-cover opacity-40 mix-blend-overlay" alt="Hero background">
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 lg:py-40 flex flex-col items-center text-center">
            <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold text-white tracking-tight mb-6 drop-shadow-lg">
                Find Your Perfect <br class="hidden md:block" /> <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-rose-500">Transformative Escape</span>
            </h1>
            <p class="mt-4 max-w-2xl text-lg md:text-xl text-slate-200 mb-10 drop-shadow">
                Discover curated wellness retreats, yoga journeys, and adventure experiences designed to reconnect you with your true self.
            </p>
            
            <a href="#tours-grid" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold rounded-full text-slate-900 bg-white hover:bg-slate-50 hover:scale-105 transition-all duration-300 shadow-xl shadow-white/10 mt-4">
                Explore Retreats
                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </a>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="bg-slate-50 min-h-screen pt-12 pb-24" id="tours-grid">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                
                <!-- Filters Sidebar -->
                <div class="w-full lg:w-72 flex-shrink-0">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100/50 p-6 sticky top-28">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                            <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                                Filter Search
                            </h2>
                            <a href="{{ route('home') }}" class="text-sm font-medium text-slate-400 hover:text-red-500 transition-colors">Clear All</a>
                        </div>
                        
                        <form action="{{ route('home') }}" method="GET" x-data="{ sending: false }" @submit="sending = true">
                            
                            <!-- Category Filter -->
                            <div class="mb-8">
                                <h3 class="text-xs font-bold text-slate-400 tracking-wider uppercase mb-4">Experience Style</h3>
                                <div class="space-y-3">
                                    @foreach ($activities as $activity)
                                    <label class="flex items-center group cursor-pointer">
                                        <div class="relative flex items-center justify-center w-5 h-5 border border-slate-300 rounded bg-white overflow-hidden transition-colors group-hover:border-red-400">
                                            <input type="checkbox" name="filter[category][]" value="{{$activity->slug}}" class="absolute w-full h-full opacity-0 cursor-pointer peer"
                                                @checked(in_array($activity->slug, request()->input('filter.category', [])))>
                                            <div class="absolute inset-0 bg-red-500 transform scale-0 peer-checked:scale-100 transition-transform duration-200"></div>
                                            <svg class="w-3.5 h-3.5 text-white absolute inset-0 m-auto transform scale-0 peer-checked:scale-100 transition-transform duration-200 delay-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <span class="ml-3 text-sm font-medium text-slate-700 group-hover:text-slate-900">{{$activity->name}}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Country Filter -->
                            <div class="mb-8">
                                <h3 class="text-xs font-bold text-slate-400 tracking-wider uppercase mb-4">Global Destinations</h3>
                                <div class="space-y-3">
                                    @foreach($countries as $country)
                                        <label class="flex items-center group cursor-pointer">
                                            <div class="relative flex items-center justify-center w-5 h-5 border border-slate-300 rounded bg-white overflow-hidden transition-colors group-hover:border-red-400">
                                                <input type="checkbox" name="filter[country][]" value="{{$country->slug}}" class="absolute w-full h-full opacity-0 cursor-pointer peer"
                                                  @checked(in_array($country->slug, request()->input('filter.country', [])))>
                                                <div class="absolute inset-0 bg-red-500 transform scale-0 peer-checked:scale-100 transition-transform duration-200"></div>
                                                <svg class="w-3.5 h-3.5 text-white absolute inset-0 m-auto transform scale-0 peer-checked:scale-100 transition-transform duration-200 delay-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <span class="ml-3 text-sm font-medium text-slate-700 group-hover:text-slate-900">{{$country->name}}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Date Filter -->
                            <div class="mb-8">
                                <h3 class="text-xs font-bold text-slate-400 tracking-wider uppercase mb-4">Availability</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">Starts After</label>
                                        <input type="date" name="filter[starts_after]" class="block w-full py-2.5 px-3 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-lg focus:ring-4 focus:ring-red-500/10 focus:border-red-500 outline-none transition-all"
                                            value="{{ request()->input('filter.starts_after') }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">Ends Before</label>
                                        <input type="date" name="filter[ends_before]" class="block w-full py-2.5 px-3 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-lg focus:ring-4 focus:ring-red-500/10 focus:border-red-500 outline-none transition-all"
                                            value="{{ request()->input('filter.ends_before') }}">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" :disabled="sending" :class="{'opacity-70 cursor-not-allowed': sending}" class="w-full flex items-center justify-center gap-2 bg-slate-900 text-white py-3 px-4 rounded-xl text-sm font-bold tracking-wide uppercase hover:bg-slate-800 focus:ring-4 focus:ring-slate-900/20 active:scale-95 transition-all">
                                <span x-show="!sending">Apply Filters</span>
                                <span x-show="sending">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Main Grid Content -->
                <div class="flex-1 min-w-0">
                    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
                        <div>
                            <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Available Retreats</h2>
                            <p class="text-slate-500 mt-1">Found {{ $tours->total() }} matches based on your criteria.</p>
                        </div>
                        
                        <!-- Sort Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" type="button" class="inline-flex items-center gap-2 bg-white border border-slate-200 shadow-sm px-4 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>
                                Sort Matches
                                <svg class="ml-1 h-4 w-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="open" x-transition x-cloak class="origin-top-right absolute right-0 mt-2 w-48 rounded-xl shadow-lg shadow-slate-200/50 bg-white ring-1 ring-black/5 focus:outline-none z-20 overflow-hidden" role="menu">
                                <div class="py-1" role="none">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => '-created_at']) }}" class="block px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-red-600">Newest Additions</a>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'price']) }}" class="block px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-red-600">Price: Low to High</a>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => '-price']) }}" class="block px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-red-600">Price: High to Low</a>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'duration_days']) }}" class="block px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-red-600">Duration: Shortest</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tour Grid -->
                     @if($tours->isEmpty())
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100/50 p-16 flex flex-col items-center justify-center text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-full border-2 border-slate-100 flex items-center justify-center mb-6">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2">No retreats found</h3>
                            <p class="text-slate-500 max-w-sm mb-6">We couldn't find any retreats matching your specific criteria. Try broadening your search filters.</p>
                            <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-bold text-red-600 hover:text-red-700 hover:underline">
                                Clear all filters
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($tours as $tour)
                                <x-tours.tour-card :tour="$tour" />
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        @if($tours->hasPages())
                            <div class="mt-12">
                                {{ $tours->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            
            <!-- Features Section -->
            <div class="mt-32 border-t border-slate-200/60 pt-20">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Why Choose VagaRetreat</h2>
                    <p class="mt-4 text-slate-500 max-w-2xl mx-auto">We partner with the world's most experienced guides to bring you transformative experiences.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10 lg:gap-16">
                    <div class="text-center group">
                        <div class="w-16 h-16 mx-auto bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Global Destinations</h3>
                        <p class="text-slate-500 leading-relaxed text-sm">Access to premium properties and sanctuaries located in the world's most serene environments.</p>
                    </div>
                    <div class="text-center group">
                        <div class="w-16 h-16 mx-auto bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Expert Instructors</h3>
                        <p class="text-slate-500 leading-relaxed text-sm">Learn and heal with certified, experienced professionals dedicated to your personal growth.</p>
                    </div>
                    <div class="text-center group">
                        <div class="w-16 h-16 mx-auto bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Secure Bookings</h3>
                        <p class="text-slate-500 leading-relaxed text-sm">Flexible cancellation policies and guaranteed secure payments for ultimate peace of mind.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

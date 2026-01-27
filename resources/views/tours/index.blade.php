<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Filters Sidebar -->
                <div class="w-full lg:w-64 flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 sticky top-8">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-bold text-gray-900">Filters</h2>
                            <a href="{{ route('api.search.index') }}" class="text-xs text-elmarzouguidev-vaga-red hover:underline">Reset</a>
                        </div>
                        
                        <form action="{{ route('api.search.index') }}" method="GET">
                            <!-- Country Filter -->
                            <div class="mb-6">
                                <h3 class="text-sm font-semibold text-gray-900 mb-3">Destinations</h3>
                                <div class="space-y-2">
                                    @foreach($countries as $country)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="filter[country][]" value="{{$country->slug}}" class="rounded border-gray-300 text-elmarzouguidev-vaga-red focus:ring-elmarzouguidev-vaga-red h-4 w-4"
                                              @checked(in_array($country->slug, request()->input('filter.country', [])))>
                                            <span class="ml-2 text-sm text-gray-600">{{$country->name}}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Category Filter -->
                            <div class="mb-6">
                                <h3 class="text-sm font-semibold text-gray-900 mb-3">Activities</h3>
                                <div class="space-y-2">
                                    @foreach ($activities as $activity )
                                    <label class="flex items-center">
                                        <input type="checkbox" name="filter[category][]" value="{{$activity->slug}}" class="rounded border-gray-300 text-elmarzouguidev-vaga-red focus:ring-elmarzouguidev-vaga-red h-4 w-4"
                                            @checked(in_array($activity->slug, request()->input('filter.category', [])))
                                            >
                                        <span class="ml-2 text-sm text-gray-600">{{$activity->name}}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Date Filter -->
                            <div class="mb-6">
                                <h3 class="text-sm font-semibold text-gray-900 mb-3">Dates</h3>
                                <input type="date" name="filter[starts_after]" class="block w-full text-sm border-gray-300 rounded-md focus:ring-elmarzouguidev-vaga-red focus:border-elmarzouguidev-vaga-red mb-2"
                                    value="{{ request()->input('filter.starts_after') }}">
                                <input type="date" name="filter[ends_before]" class="block w-full text-sm border-gray-300 rounded-md focus:ring-elmarzouguidev-vaga-red focus:border-elmarzouguidev-vaga-red"
                                    value="{{ request()->input('filter.ends_before') }}">
                            </div>

                            <button type="submit" class="w-full bg-gray-900 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-black transition-colors">
                                Apply Filters
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">
                            Found {{ $tours->count() }} Retreats
                        </h1>
                        
                        <!-- Sort Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" type="button" class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900">
                                Sort by
                                <svg class="flex-shrink-0 -mr-1 ml-1 h-5 w-5 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="open" class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                <div class="py-1" role="none">
                                    <a href="#" class="font-medium text-gray-900 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">Most Popular</a>
                                    <a href="#" class="text-gray-500 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-1">Best Rating</a>
                                    <a href="#" class="text-gray-500 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-2">Newest</a>
                                    <a href="#" class="text-gray-500 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-3">Price: Low to High</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tour Grid -->
                     @if($tours->isEmpty())
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No tours found</h3>
                            <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filters to find what you're looking for.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($tours as $tour)
                                <x-tours.tour-card :tour="$tour" />
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-8">
                            {{-- {{ $tours->links() }} --}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

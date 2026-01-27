<nav x-data="{ mobileMenuOpen: false }" class="bg-white border-b border-gray-100 relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                    <span class="text-2xl font-bold tracking-tighter text-elmarzouguidev-vaga-black">
                        VagaRetreat<span class="text-elmarzouguidev-vaga-red">.</span>
                    </span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex md:items-center md:space-x-8">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-elmarzouguidev-vaga-red font-medium transition duration-150">Home</a>
                <a href="#" class="text-gray-600 hover:text-elmarzouguidev-vaga-red font-medium transition duration-150">Destinations</a>
                <a href="#" class="text-gray-600 hover:text-elmarzouguidev-vaga-red font-medium transition duration-150">Styles</a>
                <a href="#" class="text-gray-600 hover:text-elmarzouguidev-vaga-red font-medium transition duration-150">Instructors</a>
                
                <a href="#" class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-elmarzouguidev-vaga-red hover:bg-elmarzouguidev-vaga-red-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-elmarzouguidev-vaga-red transition-colors duration-200">
                    Find a Tour
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center md:hidden">
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-elmarzouguidev-vaga-red">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Icon when menu is open -->
                    <svg x-show="mobileMenuOpen" x-cloak class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-transition x-cloak class="md:hidden border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 border-l-4 border-elmarzouguidev-vaga-red text-base font-medium text-elmarzouguidev-vaga-red bg-red-50">Home</a>
            <a href="#" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">Destinations</a>
            <a href="#" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">Styles</a>
            <a href="#" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">Instructors</a>
            <div class="pt-4 pb-2">
                <a href="#" class="block w-full text-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-elmarzouguidev-vaga-red hover:bg-elmarzouguidev-vaga-red-dark">
                    Find a Tour
                </a>
            </div>
        </div>
    </div>
</nav>

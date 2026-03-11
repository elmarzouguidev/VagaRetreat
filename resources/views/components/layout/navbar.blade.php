<nav x-data="{ mobileMenuOpen: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 10)"
     :class="{ 'bg-white/90 backdrop-blur-md shadow-sm': scrolled, 'bg-white': !scrolled }"
     class="sticky top-0 z-50 transition-all duration-300 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-500 to-rose-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-red-500/20 group-hover:shadow-red-500/40 transition duration-300">
                        V
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-slate-900 group-hover:text-red-600 transition duration-300">
                        VagaRetreat<span class="text-red-500">.</span>
                    </span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex md:items-center md:space-x-8">
                <a href="{{ route('home') }}" class="text-sm font-medium text-slate-600 hover:text-red-600 transition duration-150">Home</a>
                <a href="{{ route('home') }}?filter[category][]=yoga" class="text-sm font-medium text-slate-600 hover:text-red-600 transition duration-150">Yoga Retreats</a>
                <a href="{{ route('home') }}?filter[category][]=wellness" class="text-sm font-medium text-slate-600 hover:text-red-600 transition duration-150">Wellness</a>
                <a href="{{ route('blog.index') }}" class="text-sm font-medium text-slate-600 hover:text-red-600 transition duration-150">Journal</a>
                
                <div class="w-px h-6 bg-slate-200 mx-2"></div>
                
                @auth
                    @if(auth()->user()->hasRole('SUPERADMIN'))
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-slate-900 hover:text-red-600 transition duration-150">Admin Panel</a>
                    @else
                        <a href="{{ route('home') }}" class="text-sm font-medium text-slate-900 hover:text-red-600 transition duration-150">My Bookings</a>
                    @endif
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-slate-500 hover:text-red-600 transition duration-150">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('admin.login') }}" class="text-sm font-medium text-slate-900 hover:text-red-600 transition duration-150">Log In</a>
                @endauth
                
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-semibold rounded-full shadow-sm text-white bg-slate-900 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-all duration-300 transform hover:-translate-y-0.5">
                    Find a Retreat
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center md:hidden">
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2.5 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-slate-900 transition duration-150">
                    <span class="sr-only">Open main menu</span>
                    <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" x-cloak class="md:hidden absolute top-full left-0 w-full bg-white border-b border-slate-100 shadow-xl overflow-hidden">
        <div class="px-4 pt-2 pb-6 space-y-1">
            <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-slate-900 hover:bg-slate-50 hover:text-red-600 transition duration-150">Home</a>
            <a href="{{ route('home') }}?filter[category][]=yoga" class="block px-4 py-3 rounded-xl text-base font-medium text-slate-600 hover:bg-slate-50 hover:text-red-600 transition duration-150">Yoga Retreats</a>
            <a href="{{ route('home') }}?filter[category][]=wellness" class="block px-4 py-3 rounded-xl text-base font-medium text-slate-600 hover:bg-slate-50 hover:text-red-600 transition duration-150">Wellness</a>
            <a href="{{ route('blog.index') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-slate-600 hover:bg-slate-50 hover:text-red-600 transition duration-150">Journal</a>
            
            <div class="h-px bg-slate-100 my-4 mx-4"></div>
            
            @auth
                @if(auth()->user()->hasRole('SUPERADMIN'))
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-slate-900 hover:bg-slate-50 hover:text-red-600 transition duration-150">Admin Panel</a>
                @else
                    <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-slate-900 hover:bg-slate-50 hover:text-red-600 transition duration-150">My Bookings</a>
                @endif
                <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 rounded-xl text-base font-medium text-slate-500 hover:bg-slate-50 hover:text-red-600 transition duration-150">Log Out</button>
                </form>
            @else
                <a href="{{ route('admin.login') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-slate-900 hover:bg-slate-50 hover:text-red-600 transition duration-150">Log In</a>
            @endauth
            
            <div class="mt-6 px-4">
                <a href="{{ route('home') }}" class="flex w-full items-center justify-center px-6 py-3 border border-transparent text-base font-semibold rounded-xl text-white bg-slate-900 hover:bg-red-600 transition duration-300 shadow-md">
                    Find a Retreat
                </a>
            </div>
        </div>
    </div>
</nav>

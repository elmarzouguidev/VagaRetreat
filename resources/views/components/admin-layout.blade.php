<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — {{ config('app.name', 'VagaRetreat') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased h-full bg-gray-50" x-data="{ sidebarOpen: false }">
    <div class="flex h-full">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-black/50 lg:hidden"
             @click="sidebarOpen = false"
             x-cloak></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 transition-transform duration-300 lg:translate-x-0 lg:static lg:z-auto flex flex-col">
            
            <!-- Brand -->
            <div class="flex items-center h-16 px-6 border-b border-gray-800">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-black tracking-tighter text-white">
                    Vaga<span class="text-elmarzouguidev-vaga-red">Admin</span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-elmarzouguidev-vaga-red text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.tours.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.tours.*') ? 'bg-elmarzouguidev-vaga-red text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Tours
                </a>

                <a href="{{ route('admin.bookings.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.bookings.*') ? 'bg-elmarzouguidev-vaga-red text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Bookings
                </a>

                <a href="{{ route('admin.posts.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.posts.*') ? 'bg-elmarzouguidev-vaga-red text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    Posts
                </a>

                <a href="{{ route('admin.pages.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.pages.*') ? 'bg-elmarzouguidev-vaga-red text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Pages
                </a>
            </nav>

            <!-- User -->
            <div class="px-3 py-4 border-t border-gray-800">
                <div class="flex items-center gap-3 px-3">
                    <div class="w-8 h-8 rounded-full bg-elmarzouguidev-vaga-red flex items-center justify-center text-white text-xs font-black">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" class="mt-3 px-3">
                    @csrf
                    <button type="submit" class="w-full text-left text-xs font-semibold text-gray-500 hover:text-elmarzouguidev-vaga-red transition">
                        Sign Out →
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Bar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" target="_blank" class="text-xs font-semibold text-gray-400 hover:text-elmarzouguidev-vaga-red transition">
                        View Site →
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>

<div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden mb-6">
    <nav class="flex flex-wrap border-b border-slate-200 overflow-x-auto" aria-label="Settings Navigation">
        <!-- Core Settings -->
        <a href="{{ route('admin.settings.general') }}"
            class="flex items-center gap-2 px-5 py-4 text-sm font-medium border-b-2 transition whitespace-nowrap {{ request()->routeIs('admin.settings.general') ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Général
        </a>

        <a href="{{ route('admin.settings.app') }}"
            class="flex items-center gap-2 px-5 py-4 text-sm font-medium border-b-2 transition whitespace-nowrap {{ request()->routeIs('admin.settings.app') ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
            </svg>
            Application
        </a>

        <!-- Communications -->
        <a href="{{ route('admin.settings.email') }}"
            class="flex items-center gap-2 px-5 py-4 text-sm font-medium border-b-2 transition whitespace-nowrap {{ request()->routeIs('admin.settings.email') ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            Email
        </a>

        <a href="{{ route('admin.settings.notifications') }}"
            class="flex items-center gap-2 px-5 py-4 text-sm font-medium border-b-2 transition whitespace-nowrap {{ request()->routeIs('admin.settings.notifications') ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            Notifications
        </a>

        <!-- Business -->
        <a href="{{ route('admin.settings.payment') }}"
            class="flex items-center gap-2 px-5 py-4 text-sm font-medium border-b-2 transition whitespace-nowrap {{ request()->routeIs('admin.settings.payment') ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
            </svg>
            Paiement
        </a>

        <a href="{{ route('admin.settings.number-generation') }}"
            class="flex items-center gap-2 px-5 py-4 text-sm font-medium border-b-2 transition whitespace-nowrap {{ request()->routeIs('admin.settings.number-generation') ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
            </svg>
            Numéros
        </a>

        <!-- System -->
        <a href="{{ route('admin.settings.backup') }}"
            class="flex items-center gap-2 px-5 py-4 text-sm font-medium border-b-2 transition whitespace-nowrap {{ request()->routeIs('admin.settings.backup') ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </svg>
            Sauvegarde
        </a>

        <a href="{{ route('admin.settings.maintenance') }}"
            class="flex items-center gap-2 px-5 py-4 text-sm font-medium border-b-2 transition whitespace-nowrap {{ request()->routeIs('admin.settings.maintenance') ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Maintenance
        </a>

        <!-- Social -->
        <a href="{{ route('admin.settings.social') }}"
            class="flex items-center gap-2 px-5 py-4 text-sm font-medium border-b-2 transition whitespace-nowrap {{ request()->routeIs('admin.settings.social') ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
            </svg>
            Réseaux
        </a>
    </nav>

    <!-- Category Labels (Optional) -->
    <div class="px-6 py-2 bg-slate-50 border-t border-slate-200">
        <div class="flex flex-wrap items-center gap-6 text-xs text-slate-500">
            <span class="flex items-center gap-1">
                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                Système (5)
            </span>
            <span class="flex items-center gap-1">
                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                Communication (2)
            </span>
            <span class="flex items-center gap-1">
                <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                Business (2)
            </span>
        </div>
    </div>
</div>

<!-- Quick Profit Summary -->
<div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-sm p-6 text-white">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold">Profit Ce Mois</h3>
        <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </div>
    <p class="text-3xl font-bold">
        {{ number_format(
            \App\Models\Command\Command::where('status', 'completed')->whereMonth('created_at', now()->month)->get()->sum(fn($c) => $c->panier?->profit_price ?? 0),
            2,
        ) }}
    </p>
    <p class="text-sm opacity-90 mt-2">{{ paymentSettings()->payment_currency }}</p>
    <a href="{{ route('admin.reports.profit') }}" class="mt-4 inline-block text-sm font-medium hover:underline">
        Voir le rapport complet →
    </a>
</div>
<!-- Quick Profit Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <!-- Monthly Profit -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-sm p-6 text-white">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-medium opacity-90">Profit Ce Mois</h3>
            <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        @php
            $currentMonthProfit = \App\Models\Command\Command::where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->with('panier')
                ->get()
                ->sum(fn($c) => $c->panier?->profit_price ?? 0);
        @endphp
        <p class="text-3xl font-bold">{{ number_format($currentMonthProfit, 2) }}</p>
        <p class="text-sm opacity-90 mt-2">{{ paymentSettings()->payment_currency }}</p>
        <a href="{{ route('admin.reports.profit') }}"
            class="mt-4 inline-flex items-center text-sm font-medium hover:underline">
            Voir détails
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <!-- Today's Revenue -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-sm p-6 text-white">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-medium opacity-90">Revenu Aujourd'hui</h3>
            <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
        </div>
        @php
            $todayRevenue = \App\Models\Command\Command::where('status', 'completed')
                ->whereDate('created_at', today())
                ->sum('price');
        @endphp
        <p class="text-3xl font-bold">{{ number_format($todayRevenue, 2) }}</p>
        <p class="text-sm opacity-90 mt-2">Toutes enseignes</p>
    </div>

    <!-- Active Paniers -->
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-sm p-6 text-white">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-medium opacity-90">Paniers Actifs</h3>
            <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
        </div>
        @php
            $activePaniers = \App\Models\Panier\Panier::where('status', 'available')
                ->where('quantity', '>', 0)
                ->count();
        @endphp
        <p class="text-3xl font-bold">{{ $activePaniers }}</p>
        <p class="text-sm opacity-90 mt-2">Disponibles maintenant</p>
    </div>

    <!-- Total Enseignes -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-sm p-6 text-white">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-medium opacity-90">Enseignes Actives</h3>
            <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        @php
            $activeEnseignes = \App\Models\Enseigne::where('is_active', true)->count();
        @endphp
        <p class="text-3xl font-bold">{{ $activeEnseignes }}</p>
        <p class="text-sm opacity-90 mt-2">Partenaires Save Me</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
    <a href="{{ route('admin.reports.profit') }}"
        class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-green-300 transition group">
        <div class="flex items-start gap-4">
            <div
                class="flex-shrink-0 p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-lg group-hover:scale-110 transition">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-slate-900 mb-1 group-hover:text-green-600 transition">
                    Rapports de Profit
                </h3>
                <p class="text-sm text-slate-600">
                    Vue complète des revenus de la plateforme
                </p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.orders.index') }}"
        class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-blue-300 transition group">
        <div class="flex items-start gap-4">
            <div
                class="flex-shrink-0 p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg group-hover:scale-110 transition">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-slate-900 mb-1 group-hover:text-blue-600 transition">
                    Commandes Récentes
                </h3>
                <p class="text-sm text-slate-600">
                    Gérer les commandes en cours
                </p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.enseignes.index') }}"
        class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-purple-300 transition group">
        <div class="flex items-start gap-4">
            <div
                class="flex-shrink-0 p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg group-hover:scale-110 transition">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-slate-900 mb-1 group-hover:text-purple-600 transition">
                    Gérer Enseignes
                </h3>
                <p class="text-sm text-slate-600">
                    Voir les rapports des partenaires
                </p>
            </div>
        </div>
    </a>
</div>

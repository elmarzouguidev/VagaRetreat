@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Tableau de Bord')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Quick Profit Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Today's Profit (Save Me) -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium opacity-90">Profit Aujourd'hui</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                @php
                    $todayProfit = \App\Models\Command\Command::whereState('status', \App\States\Command\Confirmed::class)
                        ->whereDate('created_at', today())
                        ->with('panier')
                        ->get()
                        ->sum(fn($c) => $c->panier?->profit_price ?? 0);
                @endphp
                <p class="text-3xl font-bold">{{ number_format($todayProfit, 2) }}</p>
                <p class="text-sm opacity-90 mt-2">{{ paymentSettings()->payment_currency }}</p>
                <div class="mt-3 pt-3 border-t border-green-400/30">
                    <p class="text-xs opacity-75">Commission Save Me (20%)</p>
                </div>
            </div>

            <!-- Monthly Profit (Save Me) -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium opacity-90">Profit Ce Mois</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                @php
                    $monthProfit = \App\Models\Command\Command::whereState('status', \App\States\Command\Confirmed::class)
                        ->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year)
                        ->with('panier')
                        ->get()
                        ->sum(fn($c) => $c->panier?->profit_price ?? 0);
                @endphp
                <p class="text-3xl font-bold">{{ number_format($monthProfit, 2) }}</p>
                <p class="text-sm opacity-90 mt-2">{{ paymentSettings()->payment_currency }}</p>
                <a href="{{ route('admin.reports.profit') }}"
                    class="mt-3 pt-3 border-t border-blue-400/30 flex items-center text-xs opacity-90 hover:opacity-100 transition">
                    Voir rapport complet
                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- Today's Revenue (Total from customers) -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium opacity-90">Revenu Aujourd'hui</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                @php
                    $todayRevenue = \App\Models\Command\Command::whereState('status', \App\States\Command\Confirmed::class)
                        ->whereDate('created_at', today())
                        ->sum('price')/100;

                    $todayEnseigneRevenue = $todayRevenue - $todayProfit;
                @endphp
                <p class="text-3xl font-bold">{{ number_format($todayRevenue, 2) }}</p>
                <p class="text-sm opacity-90 mt-2">Total clients</p>
                <div class="mt-3 pt-3 border-t border-purple-400/30 text-xs">
                    <div class="flex items-center justify-between opacity-90">
                        <span>Enseignes (80%)</span>
                        <span class="font-semibold">{{ number_format($todayEnseigneRevenue, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Today's Orders -->
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium opacity-90">Commandes Aujourd'hui</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                @php
                    $todayOrders = \App\Models\Command\Command::whereState('status', \App\States\Command\Confirmed::class)
                        ->whereDate('created_at', today())
                        ->count();

                    $avgOrderValue = $todayOrders > 0 ? $todayRevenue / $todayOrders : 0;
                @endphp
                <p class="text-3xl font-bold">{{ $todayOrders }}</p>
                <p class="text-sm opacity-90 mt-2">Paniers vendus</p>
                <div class="mt-3 pt-3 border-t border-orange-400/30">
                    <p class="text-xs opacity-75">Panier moyen: {{ number_format($avgOrderValue, 2) }}
                        {{ paymentSettings()->payment_currency }}</p>
                </div>
            </div>
        </div>

        <!-- Detailed Breakdown Card -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Répartition des Revenus - Aujourd'hui
                </h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Total Revenue -->
                    <div
                        class="text-center p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl border border-slate-200">
                        <p class="text-sm font-medium text-slate-600 mb-2">Revenu Total</p>
                        <p class="text-3xl font-bold text-slate-900">{{ number_format($todayRevenue, 2) }}</p>
                        <p class="text-xs text-slate-500 mt-1">{{ paymentSettings()->payment_currency }}</p>
                        <p class="text-xs text-slate-400 mt-2">100% (clients)</p>
                    </div>

                    <!-- Save Me Profit -->
                    <div
                        class="text-center p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-200">
                        <p class="text-sm font-medium text-green-700 mb-2 flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Profit Save Me
                        </p>
                        <p class="text-3xl font-bold text-green-600">{{ number_format($todayProfit, 2) }}</p>
                        <p class="text-xs text-green-500 mt-1">{{ paymentSettings()->payment_currency }}</p>
                        <p class="text-xs text-green-600 font-semibold mt-2">20% Commission</p>
                    </div>

                    <!-- Enseigne Revenue -->
                    <div
                        class="text-center p-6 bg-gradient-to-br from-purple-50 to-violet-50 rounded-xl border border-purple-200">
                        <p class="text-sm font-medium text-purple-700 mb-2 flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Revenue Enseignes
                        </p>
                        <p class="text-3xl font-bold text-purple-600">{{ number_format($todayEnseigneRevenue, 2) }}</p>
                        <p class="text-xs text-purple-500 mt-1">{{ paymentSettings()->payment_currency }}</p>
                        <p class="text-xs text-purple-600 font-semibold mt-2">80% Partenaires</p>
                    </div>
                </div>

                <!-- Visual Progress Bar -->
                <div class="mt-6">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Distribution</p>
                    <div class="flex h-8 rounded-lg overflow-hidden border border-slate-200 shadow-sm">
                        @php
                            $saveMePercentage = $todayRevenue > 0 ? ($todayProfit / $todayRevenue) * 100 : 20;
                            $enseignePercentage = 100 - $saveMePercentage;
                        @endphp
                        <div class="bg-gradient-to-r from-green-500 to-green-600 flex items-center justify-center text-white text-xs font-bold"
                            style="width: {{ $saveMePercentage }}%">
                            {{ number_format($saveMePercentage, 1) }}%
                        </div>
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold"
                            style="width: {{ $enseignePercentage }}%">
                            {{ number_format($enseignePercentage, 1) }}%
                        </div>
                    </div>
                    <div class="flex justify-between mt-2 text-xs text-slate-500">
                        <span>💰 Save Me</span>
                        <span>🏪 Enseignes</span>
                    </div>
                </div>

                <!-- Quick Link -->
                <div class="mt-6 text-center">
                    <a href="{{ route('admin.reports.profit') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition font-medium text-sm shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Voir Rapport Complet des Profits
                    </a>
                </div>
            </div>
        </div>

        <!-- Rest of your existing dashboard content -->
        <!-- Active Paniers, Recent Orders, etc. -->

    </div>
@endsection

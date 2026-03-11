@extends('layouts.admin')

@section('title', 'Analytique')
@section('page-title', 'Tableau de Bord Analytique')

@section('content')
    <div class="space-y-6">
        <!-- Header with Date Range Filter -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Analytique & Rapports</h1>
                <p class="mt-1 text-sm text-slate-600">Analysez vos performances et suivez vos statistiques</p>
            </div>
            <div class="flex gap-2">
                <x-admin.button href="{{ route('admin.analytics.export') }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Exporter
                </x-admin.button>
            </div>
        </div>

        <!-- Date Range Filter -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">
            <form method="GET" action="{{ route('admin.analytics.index') }}" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[200px]">


                    <x-admin.date-picker name="start_date" id="start_date" label="Date de début" :value="$startDate"
                        placeholder="Choisir une date" />
                </div>

                <div class="flex-1 min-w-[200px]">

                    <x-admin.date-picker name="end_date" id="end_date" label="Date de Fin" :value="$endDate"
                        placeholder="Choisir une date" />
                </div>

                <div class="flex gap-2">
                    <x-admin.button type="submit">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Filtrer
                    </x-admin.button>

                    @if (request()->hasAny(['start_date', 'end_date']))
                        <x-admin.button href="{{ route('admin.analytics.index') }}" variant="outline">
                            Réinitialiser
                        </x-admin.button>
                    @endif
                </div>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Revenue -->
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-white/20 backdrop-blur-sm rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    @if ($stats['revenue']['change'] > 0)
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-white/20 backdrop-blur-sm">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            +{{ $stats['revenue']['change'] }}%
                        </span>
                    @elseif($stats['revenue']['change'] < 0)
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-red-500/20 backdrop-blur-sm">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $stats['revenue']['change'] }}%
                        </span>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-emerald-100 mb-1">Revenu Total</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['revenue']['current'], 2) }}
                        {{ paymentSettings()->payment_currency }}</p>
                </div>
            </div>

            <!-- Orders -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-white/20 backdrop-blur-sm rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    @if ($stats['orders']['change'] > 0)
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-white/20 backdrop-blur-sm">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            +{{ $stats['orders']['change'] }}%
                        </span>
                    @elseif($stats['orders']['change'] < 0)
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-red-500/20 backdrop-blur-sm">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $stats['orders']['change'] }}%
                        </span>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-blue-100 mb-1">Commandes</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['orders']['current']) }}</p>
                </div>
            </div>

            <!-- Transactions -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-white/20 backdrop-blur-sm rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    @if ($stats['transactions']['change'] > 0)
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-white/20 backdrop-blur-sm">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            +{{ $stats['transactions']['change'] }}%
                        </span>
                    @elseif($stats['transactions']['change'] < 0)
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-red-500/20 backdrop-blur-sm">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $stats['transactions']['change'] }}%
                        </span>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-purple-100 mb-1">Transactions</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['transactions']['current']) }}</p>
                </div>
            </div>

            <!-- Customers -->
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-white/20 backdrop-blur-sm rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    @if ($stats['customers']['change'] > 0)
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-white/20 backdrop-blur-sm">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            +{{ $stats['customers']['change'] }}%
                        </span>
                    @elseif($stats['customers']['change'] < 0)
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-red-500/20 backdrop-blur-sm">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $stats['customers']['change'] }}%
                        </span>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-orange-100 mb-1">Clients Actifs</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['customers']['current']) }}</p>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Revenue Chart -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                    Évolution du Revenu
                </h3>
                <div style="height: 300px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Orders Chart -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Évolution des Commandes
                </h3>
                <div style="height: 300px;">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Revenue by Status -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                </svg>
                Revenu par Statut de Commande
            </h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div style="height: 300px;">
                    <canvas id="statusChart"></canvas>
                </div>
                <div class="flex items-center justify-center">
                    <div class="space-y-3">
                        @foreach ($revenueByStatus['labels'] as $index => $label)
                            <div class="flex items-center gap-3">
                                <div class="w-4 h-4 rounded"
                                    style="background-color: {{ ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'][$index % 5] }}">
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-900">{{ $label }}</p>
                                    <p class="text-xs text-slate-600">
                                        {{ $revenueByStatus['counts'][$index] }} commandes •
                                        {{ number_format($revenueByStatus['revenues'][$index], 2) }}
                                        {{ paymentSettings()->payment_currency }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Products and Enseignes -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Products/Paniers -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Top 5 Produits
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Produits les plus vendus par revenu</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($topProducts as $index => $product)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                                        {{ $index + 1 }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-900">{{ $product->name }}</p>
                                        <div class="flex items-center gap-2 text-xs text-slate-600">
                                            @if ($product->code)
                                                <span class="inline-flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                                    </svg>
                                                    {{ $product->code }}
                                                </span>
                                            @endif
                                            <span>{{ number_format($product->total_sold) }} vendus</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-emerald-600">
                                        {{ number_format($product->total_revenue, 2) }}
                                        {{ paymentSettings()->payment_currency }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div
                                    class="w-16 h-16 bg-slate-100 rounded-full mx-auto flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-slate-900 mb-1">Aucune Donnée</h3>
                                <p class="text-sm text-slate-500">Aucun produit vendu durant cette période</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Top Enseignes -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Top 5 Enseignes
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($topEnseignes as $index => $enseigne)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-sm">
                                        {{ $index + 1 }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-900">{{ $enseigne->name }}</p>
                                        <p class="text-xs text-slate-600">{{ $enseigne->total_orders }} commandes</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-emerald-600">
                                        {{ number_format($enseigne->total_revenue, 2) }}
                                        {{ paymentSettings()->payment_currency }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-slate-500 py-8">Aucune donnée disponible</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Transactions Récentes
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Transaction</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($recentTransactions as $transaction)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.transactions.show', $transaction) }}"
                                        class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                        {{ $transaction->transaction_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm text-slate-900">
                                        {{ $transaction->command?->user?->full_name ?? 'N/A' }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm font-semibold text-slate-900">
                                        {{ number_format($transaction->price, 2) }}
                                        {{ paymentSettings()->payment_currency }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm text-slate-600">{{ $transaction->created_at?->format('d/m/Y H:i') }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction->status?->color() }}">
                                        {{ $transaction->status?->label() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                    Aucune transaction récente
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: @json($revenueData['labels']),
                    datasets: [{
                        label: 'Revenu ({{ paymentSettings()->payment_currency }})',
                        data: @json($revenueData['data']),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {

                                callback: function(value) {
                                    return value.toLocaleString() + ' {{ paymentSettings()->payment_currency }}';
                                    //return value.toFixed(2) + " {{ paymentSettings()->payment_currency }}";
                                }
                            }
                        }
                    }
                }
            });

            // Orders Chart
            const ordersCtx = document.getElementById('ordersChart').getContext('2d');
            const ordersChart = new Chart(ordersCtx, {
                type: 'bar',
                data: {
                    labels: @json($ordersData['labels']),
                    datasets: [{
                        label: 'Commandes',
                        data: @json($ordersData['data']),
                        backgroundColor: '#3b82f6',
                        borderColor: '#2563eb',
                        borderWidth: 1,
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Status Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            const statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($revenueByStatus['labels']),
                    datasets: [{
                        label: 'Revenu par Statut',
                        data: @json($revenueByStatus['revenues']),
                        backgroundColor: [
                            '#3b82f6',
                            '#10b981',
                            '#f59e0b',
                            '#ef4444',
                            '#8b5cf6'
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed.toLocaleString() +
                                        ' {{ paymentSettings()->payment_currency }}';
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection

@extends('layouts.admin')

@section('title', 'Rapport des Profits')
@section('page-title', 'Rapport des Profits Save Me')

@section('content')
    <div class="max-w-full mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Rapport des Profits</h1>
                <p class="mt-1 text-sm text-slate-600">Vue d'ensemble des revenus de la plateforme</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.reports.profit.export', request()->all()) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Exporter CSV
                </a>
            </div>
        </div>

        <!-- Date Filter -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">
            <form method="GET" action="{{ route('admin.reports.profit') }}" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[200px]">

                    <x-admin.date-picker name="start_date" label="Date de début" :value="$startDate->format('Y-m-d')"
                        placeholder="Choisir une date" />
                </div>
                <div class="flex-1 min-w-[200px]">

                    <x-admin.date-picker name="end_date" label="Date de fin" :value="$endDate->format('Y-m-d')"
                        placeholder="Choisir une date" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Période rapide</label>
                    <select name="period"
                        class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        onchange="this.form.submit()">
                        <option value="7" {{ $period == 7 ? 'selected' : '' }}>7 derniers jours</option>
                        <option value="30" {{ $period == 30 ? 'selected' : '' }}>30 derniers jours</option>
                        <option value="90" {{ $period == 90 ? 'selected' : '' }}>90 derniers jours</option>
                        <option value="365" {{ $period == 365 ? 'selected' : '' }}>12 derniers mois</option>
                    </select>
                </div>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Filtrer
                </button>
            </form>
        </div>

        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Revenue -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium opacity-90">Revenu Total</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($totalRevenue, 2) }}</p>
                <p class="text-sm opacity-80 mt-1">{{ paymentSettings()->payment_currency }}</p>
            </div>

            <!-- Save Me Profit -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium opacity-90">Profit Save Me (20%)</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($totalSaveMeProfit, 2) }}</p>
                <p class="text-sm opacity-80 mt-1">
                    Commission plateforme
                </p>
            </div>

            <!-- Enseigne Revenue -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium opacity-90">Revenu Enseignes (80%)</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($totalEnseigneRevenue, 2) }}</p>
                <p class="text-sm opacity-80 mt-1">
                    Versé aux partenaires
                </p>
            </div>

            <!-- Total Orders -->
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium opacity-90">Commandes</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($totalOrders) }}</p>
                <p class="text-sm opacity-80 mt-1">
                    Panier moyen: {{ number_format($averageOrderValue, 2) }} {{ paymentSettings()->payment_currency }}
                </p>
            </div>
        </div>

        <!-- Additional Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- User Savings -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-3 bg-teal-100 rounded-lg">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600">Économies Clients</p>
                        <p class="text-2xl font-bold text-slate-900">{{ number_format($totalUserSavings, 2) }}</p>
                    </div>
                </div>
                <p class="text-xs text-slate-500">Total des réductions obtenues par les utilisateurs</p>
            </div>

            <!-- Meals Saved -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600">Repas Sauvés</p>
                        <p class="text-2xl font-bold text-slate-900">{{ number_format($totalMealsSaved) }}</p>
                    </div>
                </div>
                <p class="text-xs text-slate-500">Nombre de paniers sauvés du gaspillage</p>
            </div>

            <!-- Growth -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-3 {{ $profitGrowth >= 0 ? 'bg-green-100' : 'bg-red-100' }} rounded-lg">
                        <svg class="w-6 h-6 {{ $profitGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600">Croissance Mois</p>
                        <p class="text-2xl font-bold {{ $profitGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $profitGrowth >= 0 ? '+' : '' }}{{ number_format($profitGrowth, 1) }}%
                        </p>
                    </div>
                </div>
                <p class="text-xs text-slate-500">
                    Ce mois: {{ number_format($currentMonthProfit, 2) }} vs Dernier:
                    {{ number_format($lastMonthProfit, 2) }}
                </p>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Daily Profit Trend -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900">Évolution des Profits (30 jours)</h2>
                </div>
                <div class="p-6">
                    <canvas id="profitTrendChart" height="250"></canvas>
                </div>
            </div>

            <!-- Revenue Distribution -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900">Répartition des Revenus</h2>
                </div>
                <div class="p-6">
                    <canvas id="revenueDistributionChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Enseignes by Profit -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900">Top 10 Enseignes par Profit</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Enseigne</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">Commandes</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">Revenu Total</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">Profit Save Me
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">Revenue Enseigne
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">% Commission</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($profitByEnseigne as $item)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($item['enseigne']?->getFirstMediaUrl('enseignes_logos'))
                                            <img src="{{ $item['enseigne']->getFirstMediaUrl('enseignes_logos') }}"
                                                alt="{{ $item['enseigne']->name }}"
                                                class="w-10 h-10 rounded-lg object-cover">
                                        @else
                                            <div
                                                class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.reports.enseigne.show', $item['enseigne']?->uuid) }}">
                                            <p class="font-medium text-slate-900">{{ $item['enseigne']?->name ?? 'N/A' }}
                                            </p>
                                            </a>
                                            <p class="text-xs text-slate-500">{{ $item['enseigne']?->code }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-semibold text-slate-900">{{ $item['orders'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-semibold text-blue-600">
                                        {{ number_format($item['total_revenue'], 2) }}
                                        {{ paymentSettings()->payment_currency }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold text-green-600">
                                        {{ number_format($item['save_me_profit'], 2) }}
                                        {{ paymentSettings()->payment_currency }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-semibold text-purple-600">
                                        {{ number_format($item['enseigne_revenue'], 2) }}
                                        {{ paymentSettings()->payment_currency }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-xs font-medium text-slate-600">
                                        {{ $item['total_revenue'] > 0 ? number_format(($item['save_me_profit'] / $item['total_revenue']) * 100, 1) : 0 }}%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    Aucune donnée disponible pour cette période
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Performing Paniers -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900">Top 5 Paniers les Plus Vendus</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Panier</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Enseigne</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">Ventes</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">Revenu Total</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">Profit Save Me
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($topPaniers as $item)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-900">{{ $item['panier']?->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-slate-500">{{ $item['panier']?->panier_number }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-900">{{ $item['panier']?->enseigne?->name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $item['sales'] }} ventes
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-semibold text-slate-900">
                                        {{ number_format($item['revenue'], 2) }} {{ paymentSettings()->payment_currency }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold text-green-600">
                                        {{ number_format($item['save_me_profit'], 2) }}
                                        {{ paymentSettings()->payment_currency }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                    Aucun panier vendu pour cette période
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Profit Trend Chart
            const profitTrendCtx = document.getElementById('profitTrendChart').getContext('2d');
            new Chart(profitTrendCtx, {
                type: 'line',
                data: {
                    labels: @json($dailyProfits->pluck('date')),
                    datasets: [{
                        label: 'Profit Save Me',
                        data: @json($dailyProfits->pluck('save_me_profit')),
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Revenue Enseignes',
                        data: @json($dailyProfits->pluck('enseigne_revenue')),
                        borderColor: 'rgb(168, 85, 247)',
                        backgroundColor: 'rgba(168, 85, 247, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toFixed(2) +
                                        ' {{ paymentSettings()->payment_currency }}';
                                }
                            }
                        }
                    }
                }
            });

            // Revenue Distribution Chart
            const distributionCtx = document.getElementById('revenueDistributionChart').getContext('2d');
            new Chart(distributionCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Profit Save Me (20%)', 'Revenue Enseignes (80%)'],
                    datasets: [{
                        data: [@json($totalSaveMeProfit), @json($totalEnseigneRevenue)],
                        backgroundColor: [
                            'rgb(34, 197, 94)',
                            'rgb(168, 85, 247)'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed.toFixed(2) +
                                        ' {{ paymentSettings()->payment_currency }}';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
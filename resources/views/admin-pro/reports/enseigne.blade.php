@extends('layouts.admin')

@section('title', 'Rapport ' . $enseigne->name)
@section('page-title', 'Rapport ' . $enseigne->name)

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                @if ($enseigne->getFirstMediaUrl('enseignes_logos'))
                    <img src="{{ $enseigne->getFirstMediaUrl('enseignes_logos') }}" alt="{{ $enseigne->name }}"
                        class="w-16 h-16 rounded-lg object-cover border-2 border-slate-200">
                @else
                    <div
                        class="w-16 h-16 rounded-lg bg-slate-100 flex items-center justify-center border-2 border-slate-200">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                @endif
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">{{ $enseigne->name }}</h1>
                    <p class="mt-1 text-sm text-slate-600">Rapport de performance</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.enseignes.show', $enseigne) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Voir Enseigne
                </a>
                <a href="{{ route('admin.reports.enseigne.export', array_merge(['enseigne' => $enseigne], request()->all())) }}"
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
            <form method="GET" action="{{ route('admin.reports.enseigne.show', $enseigne) }}"
                class="flex flex-wrap items-end gap-4">
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
            <!-- Your Revenue -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium opacity-90">Votre Revenu (80%)</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($enseigneRevenue, 2) }}</p>
                <p class="text-sm opacity-80 mt-1">{{ paymentSettings()->payment_currency }}</p>
            </div>

            <!-- Total Sales -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium opacity-90">Ventes Totales</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($totalRevenue, 2) }}</p>
                <p class="text-sm opacity-80 mt-1">
                    Commission: {{ number_format($totalSaveMeProfit, 2) }} {{ paymentSettings()->payment_currency }}
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

            <!-- Meals Saved -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium opacity-90">Repas Sauvés</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($totalMealsSaved) }}</p>
                <p class="text-sm opacity-80 mt-1">
                    Valeur: {{ number_format($totalFoodValue, 2) }} {{ paymentSettings()->payment_currency }}
                </p>
            </div>
        </div>

        <!-- Additional Metrics Row -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Growth -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-3 {{ $revenueGrowth >= 0 ? 'bg-green-100' : 'bg-red-100' }} rounded-lg">
                        <svg class="w-6 h-6 {{ $revenueGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600">Croissance</p>
                        <p class="text-2xl font-bold {{ $revenueGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $revenueGrowth >= 0 ? '+' : '' }}{{ number_format($revenueGrowth, 1) }}%
                        </p>
                    </div>
                </div>
                <p class="text-xs text-slate-500">vs mois dernier</p>
            </div>

            <!-- Customer Retention -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600">Fidélisation</p>
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($retentionRate, 1) }}%</p>
                    </div>
                </div>
                <p class="text-xs text-slate-500">{{ $repeatCustomers }}/{{ $uniqueCustomers }} clients réguliers</p>
            </div>

            <!-- Active Paniers -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-3 bg-teal-100 rounded-lg">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600">Paniers Actifs</p>
                        <p class="text-2xl font-bold text-teal-600">{{ $activePaniers }}</p>
                    </div>
                </div>
                <p class="text-xs text-slate-500">Sur {{ $totalPaniers }} paniers total</p>
            </div>

            <!-- Average Discount -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-3 bg-pink-100 rounded-lg">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600">Réduction Moy.</p>
                        <p class="text-2xl font-bold text-pink-600">{{ number_format($averageDiscount, 1) }}%</p>
                    </div>
                </div>
                <p class="text-xs text-slate-500">{{ number_format($totalDiscount, 2) }}
                    {{ paymentSettings()->payment_currency }} économisés</p>
            </div>
        </div>

        <!-- Environmental Impact -->
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-lg p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-3 bg-green-500 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-green-900 mb-1">Impact Environnemental</h3>
                    <p class="text-sm text-green-700">Votre contribution à la lutte contre le gaspillage alimentaire</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-4 bg-white rounded-lg">
                    <p class="text-3xl font-bold text-green-600">{{ number_format($totalMealsSaved) }}</p>
                    <p class="text-sm text-slate-600 mt-1">Repas sauvés</p>
                </div>
                <div class="text-center p-4 bg-white rounded-lg">
                    <p class="text-3xl font-bold text-green-600">{{ number_format($co2Saved, 1) }} kg</p>
                    <p class="text-sm text-slate-600 mt-1">CO₂ évité</p>
                </div>
                <div class="text-center p-4 bg-white rounded-lg">
                    <p class="text-3xl font-bold text-green-600">{{ number_format($waterSaved) }} L</p>
                    <p class="text-sm text-slate-600 mt-1">Eau économisée</p>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Revenue Trend -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900">Évolution du Revenu (30 jours)</h2>
                </div>
                <div class="p-6">
                    <canvas id="revenueTrendChart" height="250"></canvas>
                </div>
            </div>

            <!-- Orders by Hour -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900">Heures de Pointe</h2>
                </div>
                <div class="p-6">
                    <canvas id="peakHoursChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Performing Paniers -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900">Vos Paniers les Plus Vendus</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Panier</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">Ventes</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">Revenu Total</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">Votre Part (80%)
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">Commission (20%)
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($topPaniers as $item)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($item['panier']?->getFirstMediaUrl('paniers_cover'))
                                            <img src="{{ $item['panier']->getFirstMediaUrl('paniers_cover') }}"
                                                alt="{{ $item['panier']->name }}"
                                                class="w-12 h-12 rounded-lg object-cover">
                                        @else
                                            <div
                                                class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-slate-900">{{ $item['panier']?->name ?? 'N/A' }}
                                            </p>
                                            <p class="text-xs text-slate-500">{{ $item['panier']?->panier_number }}</p>
                                        </div>
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
                                        {{ number_format($item['total_revenue'], 2) }}
                                        {{ paymentSettings()->payment_currency }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold text-purple-600">
                                        {{ number_format($item['enseigne_revenue'], 2) }}
                                        {{ paymentSettings()->payment_currency }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-medium text-slate-600">
                                        {{ number_format($item['save_me_commission'], 2) }}
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

        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900">Commandes Récentes</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">N° Commande</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Panier</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">Votre Part</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-sm text-slate-900">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-sm font-mono font-medium text-slate-900">{{ $order->command_number }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-900">
                                    {{ $order->user?->full_name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-900">
                                    {{ $order->panier?->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-semibold text-slate-900">
                                    {{ number_format($order->price, 2) }} {{ paymentSettings()->payment_currency }}
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-bold text-purple-600">
                                    {{ number_format($order->price - (($order->panier?->profit_price ?? 0) * max(1, $order->quantity ?? 1)), 2) }}
                                    {{ paymentSettings()->payment_currency }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    Aucune commande récente
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
            // Revenue Trend Chart
            const revenueTrendCtx = document.getElementById('revenueTrendChart').getContext('2d');
            new Chart(revenueTrendCtx, {
                type: 'line',
                data: {
                    labels: @json($dailySales->pluck('date')),
                    datasets: [{
                        label: 'Votre Revenu (80%)',
                        data: @json($dailySales->pluck('enseigne_revenue')),
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
                                    return value.toFixed(2) + ' {{ paymentSettings()->payment_currency }}';
                                }
                            }
                        }
                    }
                }
            });

            // Peak Hours Chart
            const peakHoursCtx = document.getElementById('peakHoursChart').getContext('2d');
            new Chart(peakHoursCtx, {
                type: 'bar',
                data: {
                    labels: @json($peakHours->pluck('hour')->map(fn($h) => $h . 'h')),
                    datasets: [{
                        label: 'Commandes',
                        data: @json($peakHours->pluck('orders')),
                        backgroundColor: 'rgb(59, 130, 246)',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
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
        });
    </script>
@endpush

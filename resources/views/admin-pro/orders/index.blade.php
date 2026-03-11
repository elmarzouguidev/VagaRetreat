@extends('layouts.admin')

@section('title', 'Commandes')
@section('page-title', 'Commandes')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Gestion des Commandes</h1>
                <p class="mt-1 text-sm text-slate-600">Consultez et gérez toutes les commandes de paniers</p>
            </div>
            <div class="flex gap-2">
                <x-admin.button href="{{ route('admin.orders.export', array_merge(request()->query(), ['format' => 'xlsx'])) }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Excel
                </x-admin.button>
                <x-admin.button href="{{ route('admin.orders.export', array_merge(request()->query(), ['format' => 'pdf'])) }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V7l-5-5H7a2 2 0 00-2 2v15a2 2 0 002 2zM14 3v4h4" />
                    </svg>
                    Export PDF
                </x-admin.button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Total -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-5 hover:shadow-md transition">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-600 truncate">Total</p>
                        <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['total'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            <!-- Confirmed -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-5 hover:shadow-md transition">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-600 truncate">Confirmées</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($stats['confirmed'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            <!-- Delivered -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-5 hover:shadow-md transition">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-600 truncate">Livrées</p>
                        <p class="text-2xl font-bold text-purple-600">{{ number_format($stats['delivered'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            <!-- Cancelled -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-5 hover:shadow-md transition">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-600 truncate">Annulées</p>
                        <p class="text-2xl font-bold text-red-600">{{ number_format($stats['cancelled'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            <!-- Revenue -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-5 hover:shadow-md transition">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-emerald-100 rounded-lg">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-600 truncate">Revenu</p>
                        <p class="text-2xl font-bold text-emerald-600">{{ number_format($stats['revenue'] / 100 ?? 0, 2) }}
                            {{ paymentSettings()->payment_currency }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <form method="GET" action="{{ route('admin.orders.index') }}"
                class="space-y-4 sm:space-y-0 sm:flex sm:items-end sm:gap-4">

                <!-- Search Input -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-slate-700 mb-2">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Rechercher
                    </label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Rechercher par numéro de commande ou client..."
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>

                <!-- Status Filter -->
                <div class="sm:w-48">
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Statut
                    </label>
                    <select id="status" name="status"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">Tous les statuts</option>
                        <option value="pending" @selected(request('status') === 'pending')>En attente</option>
                        <option value="confirmed" @selected(request('status') === 'confirmed')>Confirmée</option>
                        <option value="ready" @selected(request('status') === 'ready')>Prête</option>
                        <option value="delivered" @selected(request('status') === 'delivered')>Livrée</option>
                        <option value="cancelled" @selected(request('status') === 'cancelled')>Annulée</option>
                    </select>
                </div>

                <!-- Enseigne Filter -->
                <div class="sm:w-56">
                    <label for="enseigne" class="block text-sm font-medium text-slate-700 mb-2">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Enseigne
                    </label>
                    <select id="enseigne" name="enseigne"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">Toutes les enseignes</option>
                        @foreach ($enseignes ?? [] as $enseigne)
                            <option value="{{ $enseigne->id }}" @selected(request('enseigne') == $enseigne->id)>
                                {{ $enseigne->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <x-admin.button type="submit" variant="primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Rechercher
                    </x-admin.button>

                    @if (request()->hasAny(['search', 'status', 'enseigne']))
                        <x-admin.button href="{{ route('admin.orders.index') }}" variant="outline">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Réinitialiser
                        </x-admin.button>
                    @endif
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                    Commande
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Client
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Panier
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    Qté
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Total
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Date
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Statut
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($orders ?? [] as $order)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <!-- Order Number -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <a href="{{ route('admin.orders.show', $order) }}"
                                                class="text-sm font-medium text-slate-900 hover:text-blue-600 transition-colors">
                                                {{ $order->command_number }}
                                            </a>
                                            <p class="text-xs text-slate-500 mt-0.5">
                                                #{{ $order->id }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Customer -->
                                <td class="px-6 py-4">
                                    @if ($order->user)
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-semibold text-slate-700">
                                                {{ substr($order->user->full_name, 0, 2) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-slate-900 truncate">
                                                    {{ $order->user->full_name }}
                                                </p>
                                                <p class="text-xs text-slate-500 truncate">
                                                    {{ $order->user->email }}
                                                </p>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-slate-400 text-sm">—</span>
                                    @endif
                                </td>

                                <!-- Panier -->
                                <td class="px-6 py-4">
                                    @if ($order->panier)
                                        <div class="min-w-0">
                                            <a href="{{ route('admin.paniers.show', $order->panier) }}"
                                                class="text-sm font-medium text-blue-600 hover:text-blue-800 line-clamp-1">
                                                {{ $order->panier?->name }}
                                            </a>
                                            @if ($order->panier?->enseigne)
                                                <p class="text-xs text-slate-500 mt-0.5">
                                                    {{ $order->panier?->enseigne?->name }}
                                                </p>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-slate-400 text-sm">—</span>
                                    @endif
                                </td>

                                <!-- Quantity -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-slate-900">
                                        {{ $order->quantity }}
                                    </span>
                                </td>

                                <!-- Total Price -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-slate-900">
                                        {{ number_format($order->price, 2) }} {{ paymentSettings()->payment_currency }}
                                    </span>
                                </td>

                                <!-- Date -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $order->created_at?->format('d/m/Y') }}
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->status?->color() }}">
                                        @if ($order->status?->value() === \App\States\Command\Livred::$name)
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @elseif($order->status?->value() === \App\States\Command\Cancelled::$name)
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                        {{ $order->status?->label() }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Voir
                                        </a>

                                        @if ($order->status?->canTransitionTo(\App\States\Command\Cancelled::class, 'OK'))
                                            <form method="POST" action="{{ route('admin.orders.cancel', $order) }}"
                                                class="inline"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Annuler
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-slate-900 mb-1">Aucune Commande</h3>
                                        <p class="text-sm text-slate-500">Les commandes apparaîtront ici une fois passées.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if (isset($orders) && $orders->hasPages())
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 px-4 py-3">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection

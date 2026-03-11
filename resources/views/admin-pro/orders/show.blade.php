@extends('layouts.admin')

@section('title', 'Détails Commande')
@section('page-title', $order->command_number)

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <x-admin.button href="{{ route('admin.orders.index') }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour aux Commandes
                </x-admin.button>

                <div class="flex gap-2">
                    <!-- Status Update Dropdown -->
                    @can('update', $order)
                        <div class="relative" x-data="{ open: false }" style="z-index: 50;">
                            <button @click="open = !open" type="button"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Changer Statut
                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-slate-200 py-1"
                                style="z-index: 9999; display: none;" x-cloak>

                                <!-- Confirmed -->
                                <form method="POST" action="{{ route('admin.orders.update.status', $order) }}"
                                    class="inline w-full">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 flex items-center gap-2 transition">
                                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                        Confirmée
                                    </button>
                                </form>

                                <!-- Ready -->
                                <form method="POST" action="{{ route('admin.orders.update.status', $order) }}"
                                    class="inline w-full">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="ready">
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 flex items-center gap-2 transition">
                                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                        Prête
                                    </button>
                                </form>

                                <!-- Delivered -->
                                <form method="POST" action="{{ route('admin.orders.update.status', $order) }}"
                                    class="inline w-full">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="delivered">
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 flex items-center gap-2 transition">
                                        <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                                        Livrée
                                    </button>
                                </form>

                                <!-- Cancelled -->
                                <form method="POST" action="{{ route('admin.orders.update.status', $order) }}"
                                    class="inline w-full">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit"
                                        onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?')"
                                        class="w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 flex items-center gap-2 transition border-t border-slate-200">
                                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                        Annulée
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endcan

                    @if ($order->status?->canTransitionTo(\App\States\Command\Cancelled::class))
                        <form method="POST" action="{{ route('admin.orders.cancel', $order) }}"
                            onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette commande ? Cette action est irréversible.')">
                            @csrf
                            @method('PUT')
                            <x-admin.button type="submit" variant="danger">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Annuler la Commande
                            </x-admin.button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Overview Card -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-6">
                            <div>
                                <h1 class="text-2xl font-bold text-slate-900">{{ $order->command_number }}</h1>
                                <p class="text-sm text-slate-600 mt-1">
                                    Commande passée le {{ $order->created_at?->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium {{ $order->status?->color() }}">
                                @if ($order->status?->value() === \App\States\Command\Livred::$name)
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @elseif($order->status?->value() === \App\States\Command\Cancelled::$name)
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                                {{ $order->status?->label() }}
                            </span>
                        </div>

                        <!-- Order Summary -->
                        <div
                            class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-200 mb-6">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-blue-600 font-medium mb-1">Quantité</p>
                                    <p class="text-3xl font-bold text-blue-900">{{ $order->quantity }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-blue-600 font-medium mb-1">Prix Total</p>
                                    <p class="text-3xl font-bold text-blue-900">
                                        {{ number_format($order->price, 2) }} <span class="text-xl">{{ paymentSettings()->payment_currency }}</span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Details -->
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Prix Unitaire
                                </dt>
                                <dd class="text-sm text-slate-900 font-semibold">
                                    {{ number_format($order->price, 2) }} {{ paymentSettings()->payment_currency }}
                                </dd>
                            </div>

                            <div>
                                <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Date de Création
                                </dt>
                                <dd class="text-sm text-slate-900 font-semibold">
                                    {{ $order->created_at?->format('d/m/Y à H:i:s') }}
                                </dd>
                            </div>

                            <div>
                                <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Dernière Mise à Jour
                                </dt>
                                <dd class="text-sm text-slate-900 font-semibold">
                                    {{ $order->updated_at?->format('d/m/Y à H:i:s') }}
                                </dd>
                            </div>

                            @if ($order->collected_at)
                                <div>
                                    <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Date de Collecte
                                    </dt>
                                    <dd class="text-sm text-slate-900 font-semibold">
                                        {{ $order->collected_at?->format('d/m/Y à H:i:s') }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Panier Details -->
                @if ($order->panier)
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                Détails du Panier
                            </h2>
                        </div>

                        <div class="p-6">
                            <div class="flex items-start gap-4 mb-4">
                                @if ($order->panier->getFirstMediaUrl('paniers_cover'))
                                    <img src="{{ $order->panier->getFirstMediaUrl('paniers_cover') }}"
                                        alt="{{ $order->panier->name }}"
                                        class="w-20 h-20 rounded-lg object-cover border border-slate-200">
                                @else
                                    <div
                                        class="w-20 h-20 rounded-lg bg-slate-100 flex items-center justify-center border border-slate-200">
                                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <h3 class="font-medium text-slate-900">{{ $order->panier->name }}</h3>
                                    <p class="text-sm text-slate-600 mt-1">{{ $order->panier->panier_number }}</p>
                                    @if ($order->panier->content)
                                        <p class="text-sm text-slate-700 mt-2">
                                            {{ Str::limit($order->panier->content, 200) }}</p>
                                    @endif
                                </div>
                            </div>

                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 pt-4 border-t border-slate-200">
                                <div>
                                    <dt class="text-sm font-medium text-slate-700 mb-1">Prix du Panier</dt>
                                    <dd class="text-sm text-slate-900 font-semibold">
                                        {{ number_format($order->panier->price, 2) }} {{ paymentSettings()->payment_currency }}
                                    </dd>
                                </div>

                                @if ($order->panier->discount > 0)
                                    <div>
                                        <dt class="text-sm font-medium text-slate-700 mb-1">Réduction</dt>
                                        <dd class="text-sm text-green-600 font-semibold">
                                            -{{ number_format($order->panier->discount, 2) }} {{ paymentSettings()->payment_currency }}
                                        </dd>
                                    </div>
                                @endif

                                @if ($order->panier->collect_day)
                                    <div>
                                        <dt class="text-sm font-medium text-slate-700 mb-1">Date de Collecte</dt>
                                        <dd class="text-sm text-slate-900 font-semibold">
                                            {{ $order->panier->collect_day?->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                                        </dd>
                                    </div>
                                @endif

                                @if ($order->panier->collect_time_start && $order->panier->collect_time_end)
                                    <div>
                                        <dt class="text-sm font-medium text-slate-700 mb-1">Horaire de Collecte</dt>
                                        <dd class="text-sm text-slate-900 font-semibold">
                                            {{ $order->panier->collect_time_start?->format('H:i') }} -
                                            {{ $order->panier->collect_time_end?->format('H:i') }}
                                        </dd>
                                    </div>
                                @endif
                            </dl>

                            <div class="mt-4 pt-4 border-t border-slate-200">
                                <a href="{{ route('admin.paniers.show', $order->panier) }}"
                                    class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800">
                                    Voir le panier complet
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Transactions -->
                @if ($order->transactions->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Transactions ({{ $order->transactions->count() }})
                            </h2>
                        </div>

                        <div class="divide-y divide-slate-200">
                            @foreach ($order->transactions as $transaction)
                                <div class="px-6 py-4 hover:bg-slate-50 transition">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-slate-900">
                                                {{ $transaction->transaction_number }}</h4>
                                            <p class="text-xs text-slate-600 mt-1 font-mono">
                                                {{ $transaction->transaction_stripe_id }}
                                            </p>
                                            <p class="text-xs text-slate-500 mt-1">
                                                {{ $transaction->created_at?->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div class="text-right ml-4">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction->status?->color() }}">
                                                {{ $transaction->status?->label() }}
                                            </span>
                                            <p class="text-sm font-semibold text-slate-900 mt-2">
                                                {{ number_format($transaction->price, 2) }} {{ paymentSettings()->payment_currency }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex gap-2">
                                        <a href="{{ route('admin.transactions.show', $transaction) }}"
                                            class="text-xs text-blue-600 hover:text-blue-800">
                                            Voir la transaction
                                        </a>
                                        <span class="text-slate-300">•</span>
                                        <a href="{{ getStripePaymentIntentDashboardUrl($transaction->transaction_stripe_id) }}"
                                            target="_blank"
                                            class="text-xs text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                                            Voir sur Stripe
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Customer Info -->
                @if ($order->user)
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Client
                            </h2>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-lg font-semibold">
                                    {{ substr($order->user->full_name, 0, 2) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-slate-900">{{ $order->user->full_name }}</p>
                                    <p class="text-sm text-slate-600 truncate">{{ $order->user->email }}</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                @if ($order->user->telephone)
                                    <a href="tel:{{ $order->user->telephone }}"
                                        class="flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ $order->user->telephone }}
                                    </a>
                                @endif

                                <a href="mailto:{{ $order->user->email }}"
                                    class="flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $order->user->email }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Enseigne Info -->
                @if ($order->panier?->enseigne)
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Enseigne
                            </h2>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-4">
                                @if ($order->panier->enseigne->getFirstMediaUrl('enseignes_logo'))
                                    <img src="{{ $order->panier->enseigne->getFirstMediaUrl('enseignes_logo') }}"
                                        alt="{{ $order->panier->enseigne->name }}"
                                        class="w-12 h-12 rounded-lg object-cover border border-slate-200">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-slate-900">{{ $order->panier->enseigne->name }}</p>
                                    <p class="text-sm text-slate-600">{{ $order->panier->enseigne->code }}</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                @if ($order->panier->enseigne->telephone)
                                    <a href="tel:{{ $order->panier->enseigne->telephone }}"
                                        class="flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ $order->panier->enseigne->telephone }}
                                    </a>
                                @endif

                                @if ($order->panier->enseigne->address)
                                    <div class="flex items-start gap-2 text-sm text-slate-700">
                                        <svg class="w-4 h-4 mt-0.5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>{{ $order->panier->enseigne->address }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-4 pt-4 border-t border-slate-200">
                                <a href="{{ route('admin.enseignes.show', $order->panier->enseigne) }}"
                                    class="text-sm text-blue-600 hover:text-blue-800 flex items-center justify-center gap-1">
                                    Voir l'enseigne
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- System Info -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900">Informations Système</h2>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">ID</label>
                            <p class="text-sm text-slate-900">#{{ $order->id }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">UUID</label>
                            <p class="text-xs text-slate-600 font-mono break-all">{{ $order->uuid }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Créé le</label>
                            <p class="text-sm text-slate-900">{{ $order->created_at?->format('d/m/Y à H:i:s') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Dernière modification</label>
                            <p class="text-sm text-slate-900">{{ $order->updated_at?->format('d/m/Y à H:i:s') }}</p>
                        </div>

                        @if ($order->updated_at->gt($order->created_at))
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Modifié il y a</label>
                                <p class="text-sm text-slate-900">{{ $order->updated_at->diffForHumans() }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

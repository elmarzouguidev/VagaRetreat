@extends('layouts.admin')

@section('title', 'Détails Panier')
@section('page-title', $panier->name)

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <x-admin.button href="{{ route('admin.paniers.index') }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour aux Paniers
                </x-admin.button>

                <div class="flex gap-2">
                    <x-admin.button href="{{ route('admin.paniers.products.add', $panier) }}" variant="primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Ajouter des Produits
                    </x-admin.button>
                    @can('update', $panier)
                        <x-admin.button href="{{ route('admin.paniers.edit', $panier) }}" variant="primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Modifier
                        </x-admin.button>
                    @endcan


                    <!-- Status Update Dropdown -->
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

                            <button type="button" onclick="updateStatus('available')"
                                class="w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 flex items-center gap-2 transition">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                Disponible
                            </button>

                            <button type="button" onclick="updateStatus('not_available')"
                                class="w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 flex items-center gap-2 transition">
                                <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                                Non Disponible
                            </button>

                            <button type="button" onclick="updateStatus('draft')"
                                class="w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 flex items-center gap-2 transition">
                                <span class="w-2 h-2 rounded-full bg-gray-500"></span>
                                Brouillon
                            </button>

                            <button type="button" onclick="updateStatus('terminated')"
                                class="w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 flex items-center gap-2 transition">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                Terminé
                            </button>
                        </div>
                    </div>
                    <!-- Hidden Form -->
                    <form id="status-form" method="POST" action="{{ route('admin.paniers.update.status', $panier) }}"
                        style="display: none;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" id="status-input">
                    </form>
                    @can('delete', $panier)
                        <form method="POST" action="{{ route('admin.paniers.delete') }}"
                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce panier ? Cette action est irréversible.')">
                            @csrf
                            @method('DELETE')
                            @honeypot
                            <input type="hidden" name="panier" value="{{ $panier->uuid }}">
                            <x-admin.button type="submit" variant="danger">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Supprimer
                            </x-admin.button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Overview Card -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="p-6">
                        <div class="flex items-start gap-6">
                            <!-- Cover Photo -->
                            <div class="flex-shrink-0">
                                @if ($panier->getFirstMediaUrl('paniers_cover'))
                                    <img src="{{ $panier->getFirstMediaUrl('paniers_cover') }}" alt="{{ $panier->name }}"
                                        class="w-32 h-32 rounded-lg object-cover border-2 border-slate-200">
                                @else
                                    <div
                                        class="w-32 h-32 rounded-lg bg-slate-100 flex items-center justify-center border-2 border-slate-200">
                                        <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <h1 class="text-2xl font-bold text-slate-900">{{ $panier->name }}</h1>
                                        @if ($panier->type)
                                            <p class="mt-1 text-sm text-slate-600">{{ $panier->type?->name }}</p>
                                        @endif
                                    </div>
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium {{ $panier->status?->color() }}">
                                        @if ($panier->status?->value() == \App\States\Panier\Available::$name)
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                        {{ $panier->status?->label() }}
                                    </span>
                                </div>

                                @if ($panier->content)
                                    <p class="mt-4 text-slate-700">{{ $panier->content }}</p>
                                @endif

                                <!-- Quick Info -->
                                <div class="mt-4 grid grid-cols-2 gap-4">
                                    <div class="flex items-center gap-2 text-sm">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                        </svg>
                                        <span class="text-slate-600">Code:</span>
                                        <span
                                            class="font-mono font-semibold text-slate-900">{{ $panier->panier_number }}</span>
                                    </div>

                                    <div class="flex items-center gap-2 text-sm">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        <span class="text-slate-600">Quantité:</span>
                                        <span class="font-semibold text-slate-900">{{ $panier->quantity }} unités</span>
                                    </div>
                                </div>

                                <!-- Pricing -->
                                <div class="mt-4 flex items-center gap-4">
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-3xl font-bold text-slate-900">{{ $panier->price }}
                                            MAD</span>
                                        @if ($panier->discount > 0)
                                            <span
                                                class="text-lg text-slate-500 line-through">{{ $panier->price + $panier->discount }}
                                                MAD</span>
                                            <span
                                                class="text-sm font-semibold text-green-600 bg-green-50 px-2 py-1 rounded">
                                                -{{ $panier->discount }} MAD
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Collection Details -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Informations de Collecte
                        </h2>
                    </div>

                    <div class="p-6">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Collection Date -->
                            <div>
                                <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Date de Collecte
                                </dt>
                                <dd class="text-sm text-slate-900 font-semibold">
                                    {{ $panier->collect_day?->locale('fr')?->isoFormat('dddd D MMMM YYYY') }}
                                </dd>
                            </div>

                            <!-- Collection Time -->
                            <div>
                                <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Horaire de Collecte
                                </dt>
                                <dd class="text-sm text-slate-900 font-semibold">
                                    {{ $panier->collect_time_start?->format('H:i') }} -
                                    {{ $panier->collect_time_end?->format('H:i') }}
                                </dd>
                            </div>

                            <!-- Collection Address -->
                            <div class="md:col-span-2">
                                <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Adresse de Collecte
                                </dt>
                                <dd class="text-sm text-slate-900 bg-slate-50 rounded-lg p-4 border border-slate-200">
                                    {{ $panier->collect_address }}
                                    @if ($panier->city)
                                        <br>
                                        <span class="text-slate-600">{{ $panier->city?->name }}</span>
                                    @endif
                                </dd>
                            </div>

                            <!-- Distance (if available) -->
                            @if ($panier->km)
                                <div>
                                    <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                        </svg>
                                        Distance Estimée
                                    </dt>
                                    <dd class="text-sm text-slate-900 font-semibold">{{ $panier->km }} km</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Products in Panier -->
                @if ($panier->products?->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Produits Inclus ({{ $panier->products?->count() }})
                            </h2>
                        </div>

                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach ($panier->products as $product)
                                    <div
                                        class="flex items-center gap-4 p-4 bg-slate-50 rounded-lg border border-slate-200">
                                        @if ($product->getFirstMediaUrl('products_photos', 'thumb'))
                                            <img src="{{ $product->getFirstMediaUrl('products_photos', 'thumb') }}"
                                                alt="{{ $product->name }}" class="w-16 h-16 rounded-lg object-cover">
                                        @else
                                            <div
                                                class="w-16 h-16 rounded-lg bg-slate-200 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <h4 class="font-medium text-slate-900">{{ $product->name }}</h4>
                                            <p class="text-sm text-slate-600">Quantité:
                                                {{ $product->pivot?->quantity ?? 1 }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-slate-900">
                                                {{ number_format($product->pivot?->price ?? $product->price, 2) }} MAD</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Commands -->
                @if (isset($stats) && $stats['total_commands'] > 0)
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Commandes ({{ $stats['total_commands'] }})
                            </h2>
                        </div>

                        <div class="divide-y divide-slate-200">
                            @foreach ($panier->commands()->latest()->take(5)->get() as $command)
                                <div class="px-6 py-4 hover:bg-slate-50 transition">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-slate-900">{{ $command->command_number }}
                                            </h4>
                                            <p class="text-sm text-slate-600 mt-1">
                                                {{ $command->user?->full_name }}
                                            </p>
                                            <p class="text-xs text-slate-500 mt-1">
                                                {{ $command->created_at?->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $command->status?->color() }}">
                                                {{ $command->status?->label() }}
                                            </span>
                                            <p class="text-sm font-semibold text-slate-900 mt-2">
                                                {{ number_format($command->price, 2) }} MAD
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if ($panier->commands()?->count() > 5)
                            <div class="px-6 py-3 bg-slate-50 border-t border-slate-200">
                                <a href="{{ route('admin.orders.index', ['panier' => $panier->uuid]) }}"
                                    class="text-sm text-blue-600 hover:text-blue-800 flex items-center justify-center gap-1">
                                    Voir toutes les commandes
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Right Column - Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Enseigne Info -->
                @if ($panier->enseigne)
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
                                @if ($panier->enseigne?->getFirstMediaUrl('enseignes_logos'))
                                    <img src="{{ $panier->enseigne?->getFirstMediaUrl('enseignes_logos') }}"
                                        alt="{{ $panier->enseigne?->name }}"
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
                                    <p class="font-medium text-slate-900">{{ $panier->enseigne?->name }}</p>
                                    <p class="text-sm text-slate-600 truncate">{{ $panier->enseigne?->code }}</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                @if ($panier->enseigne?->telephone)
                                    <a href="tel:{{ $panier->enseigne?->telephone }}"
                                        class="flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ $panier->enseigne?->telephone }}
                                    </a>
                                @endif

                                @if ($panier->enseigne?->email)
                                    <a href="mailto:{{ $panier->enseigne?->email }}"
                                        class="flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        {{ $panier->enseigne?->email }}
                                    </a>
                                @endif
                            </div>

                            <div class="mt-4 pt-4 border-t border-slate-200">
                                <a href="{{ route('admin.enseignes.show', $panier->enseigne) }}"
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

                <!-- Statistics -->
                @if (isset($stats))
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900">Statistiques</h2>
                        </div>

                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-600">Commandes</span>
                                <span class="text-lg font-bold text-blue-600">{{ $stats['total_commands'] }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-600">Revenu Total</span>
                                <span
                                    class="text-lg font-bold text-green-600">{{ number_format($stats['total_revenue'] / 100, 2) }}
                                    MAD</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-600">Quantité Restante</span>
                                <span class="text-lg font-bold text-orange-600">{{ $stats['remaining_quantity'] }}</span>
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
                            <p class="text-sm text-slate-900">#{{ $panier->id }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">UUID</label>
                            <p class="text-xs text-slate-600 font-mono break-all">{{ $panier->uuid }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Créé le</label>
                            <p class="text-sm text-slate-900">{{ $panier->created_at?->format('d/m/Y à H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Dernière modification</label>
                            <p class="text-sm text-slate-900">{{ $panier->updated_at?->format('d/m/Y à H:i') }}</p>
                        </div>

                        @if ($panier->updated_at?->gt($panier->created_at))
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Modifié il y a</label>
                                <p class="text-sm text-slate-900">{{ $panier->updated_at?->diffForHumans() }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function updateStatus(status) {
            if (confirm('Êtes-vous sûr de vouloir changer le statut de ce panier ?')) {
                document.getElementById('status-input').value = status;
                document.getElementById('status-form').submit();
            }
        }
    </script>
@endpush

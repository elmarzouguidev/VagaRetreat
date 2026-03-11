@extends('layouts.admin')

@section('title', 'Détails Enseigne')
@section('page-title', $enseigne->name)

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <x-admin.button href="{{ route('admin.enseignes.index') }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour aux Enseignes
                </x-admin.button>

                <div class="flex gap-2">
                    <x-admin.button href="{{ route('admin.reports.enseigne.show', $enseigne) }}" variant="primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Voir Rapport Détaillé
                    </x-admin.button>

                    @can('update', $enseigne)
                        <x-admin.button href="{{ route('admin.enseignes.edit', $enseigne) }}" variant="primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Modifier
                        </x-admin.button>
                    @endcan

                    @can('delete', $enseigne)
                        <form method="POST" action="{{ route('admin.enseignes.delete') }}"
                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette enseigne ? Cette action est irréversible.')">
                            @csrf
                            @method('DELETE')
                            @honeypot
                            <input type="hidden" name="enseigne" value="{{ $enseigne->uuid }}">
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
                            <!-- Logo -->
                            <div class="flex-shrink-0">
                                @if ($enseigne->getFirstMediaUrl('enseignes_logos'))
                                    <img src="{{ $enseigne->getFirstMediaUrl('enseignes_logos') }}"
                                        alt="{{ $enseigne->name }}"
                                        class="w-24 h-24 rounded-lg object-cover border-2 border-slate-200">
                                @else
                                    <div
                                        class="w-24 h-24 rounded-lg bg-slate-100 flex items-center justify-center border-2 border-slate-200">
                                        <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <h1 class="text-2xl font-bold text-slate-900">{{ $enseigne->name }}</h1>
                                        @if ($enseigne->enseigneType)
                                            <p class="mt-1 text-sm text-slate-600">{{ $enseigne->enseigneType?->name }}</p>
                                        @endif
                                    </div>
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium {{ $enseigne->status?->badgeClasses() }}">
                                        @if ($enseigne->status?->value === 'OPEN')
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                        {{ $enseigne->status?->label() }}
                                    </span>
                                </div>

                                @if ($enseigne->content)
                                    <p class="mt-4 text-slate-700">{{ $enseigne->content }}</p>
                                @endif

                                <!-- Quick Info -->
                                <div class="mt-4 flex flex-wrap gap-4">
                                    <div class="flex items-center gap-2 text-sm text-slate-600">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                        </svg>
                                        <span class="font-mono">{{ $enseigne->code }}</span>
                                    </div>

                                    @if ($enseigne->city)
                                        <div class="flex items-center gap-2 text-sm text-slate-600">
                                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $enseigne->city?->name }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Coordonnées
                        </h2>
                    </div>

                    <div class="p-6 space-y-4">
                        <!-- Email -->
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-slate-700 mb-1">E-mail</label>
                                <a href="mailto:{{ $enseigne->email }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $enseigne->email }}
                                </a>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Téléphone</label>
                                <a href="tel:{{ $enseigne->telephone }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $enseigne->telephone }}
                                </a>
                            </div>
                        </div>

                        <!-- Website -->
                        @if ($enseigne->website)
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Site Web</label>
                                    <a href="{{ $enseigne->website }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                        {{ $enseigne->website }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endif

                        <!-- Address -->
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Adresse</label>
                                <p class="text-slate-900">{{ $enseigne->address }}</p>
                                @if ($enseigne->city)
                                    <p class="text-sm text-slate-600 mt-1">{{ $enseigne->city?->name }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Information -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Informations Commerciales
                        </h2>
                    </div>

                    <div class="p-6">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if ($enseigne->ice)
                                <div>
                                    <dt class="text-sm font-medium text-slate-700 mb-1">SIRET / ICE</dt>
                                    <dd class="text-sm text-slate-900 font-mono">{{ $enseigne->ice }}</dd>
                                </div>
                            @endif

                            @if ($enseigne->rc)
                                <div>
                                    <dt class="text-sm font-medium text-slate-700 mb-1">Numéro de TVA</dt>
                                    <dd class="text-sm text-slate-900 font-mono">{{ $enseigne->rc }}</dd>
                                </div>
                            @endif

                            {{-- @if ($enseigne->opening_hours)
                                <div class="md:col-span-2">
                                    <dt class="text-sm font-medium text-slate-700 mb-2">Horaires d'Ouverture</dt>
                                    <dd
                                        class="text-sm text-slate-900 whitespace-pre-line bg-slate-50 rounded-lg p-4 border border-slate-200">
                                        {{ $enseigne->opening_hours }}</dd>
                                </div>
                            @endif --}}
                        </dl>
                    </div>

                </div>

                <!-- Statistics -->
                @if (isset($stats))
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Statistiques
                            </h2>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-600">{{ $stats['total_products'] ?? 0 }}
                                    </div>
                                    <div class="text-sm text-slate-600 mt-1">Produits</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600">{{ $stats['total_paniers'] ?? 0 }}
                                    </div>
                                    <div class="text-sm text-slate-600 mt-1">Paniers</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-purple-600">{{ $stats['total_commands'] ?? 0 }}
                                    </div>
                                    <div class="text-sm text-slate-600 mt-1">Commandes</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-orange-600">
                                        {{ number_format($stats['total_revenue'] / 100 ?? 0, 2) }} MAD</div>
                                    <div class="text-sm text-slate-600 mt-1">Revenu Total</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Professional Info -->
                @if ($enseigne->user)
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Professionnel
                            </h2>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-lg font-semibold">
                                    {{ substr($enseigne->user?->full_name, 0, 2) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-slate-900">{{ $enseigne->user?->full_name }}</p>
                                    <p class="text-sm text-slate-600 truncate">{{ $enseigne->user?->email }}</p>
                                </div>
                            </div>

                            @if ($enseigne->user?->telephone)
                                <div class="mt-4 pt-4 border-t border-slate-200">
                                    <a href="tel:{{ $enseigne->user?->telephone }}"
                                        class="flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ $enseigne->user?->telephone }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900">Actions Rapides</h2>
                    </div>

                    <div class="p-6 space-y-3">
                        <a href="{{ route('admin.products.index', ['enseigne' => $enseigne->id]) }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-50 transition group">
                            <div
                                class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-200 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-slate-900">Voir les Produits</p>
                                <p class="text-sm text-slate-600">{{ $stats['total_products'] ?? 0 }} produits</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.paniers.index', ['enseigne' => $enseigne->id]) }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-50 transition group">
                            <div
                                class="w-10 h-10 rounded-lg bg-green-100 text-green-600 flex items-center justify-center group-hover:bg-green-200 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-slate-900">Voir les Paniers</p>
                                <p class="text-sm text-slate-600">{{ $stats['total_paniers'] ?? 0 }} paniers</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.orders.index', ['enseigne' => $enseigne->id]) }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-50 transition group">
                            <div
                                class="w-10 h-10 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center group-hover:bg-purple-200 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-slate-900">Voir les Commandes</p>
                                <p class="text-sm text-slate-600">{{ $stats['total_commands'] ?? 0 }} commandes</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- System Info -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900">Informations Système</h2>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">ID</label>
                            <p class="text-sm text-slate-900">#{{ $enseigne->id }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">UUID</label>
                            <p class="text-xs text-slate-600 font-mono break-all">{{ $enseigne->uuid }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Créé le</label>
                            <p class="text-sm text-slate-900">{{ $enseigne->created_at?->format('d/m/Y à H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Dernière modification</label>
                            <p class="text-sm text-slate-900">{{ $enseigne->updated_at?->format('d/m/Y à H:i') }}</p>
                        </div>

                        @if ($enseigne->updated_at?->gt($enseigne->created_at))
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Modifié il y a</label>
                                <p class="text-sm text-slate-900">{{ $enseigne->updated_at?->diffForHumans() }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

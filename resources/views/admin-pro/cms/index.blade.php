@extends('layouts.admin')

@section('title', 'CMS')
@section('page-title', 'CMS & Référentiels')

@php
    $modules = [
        [
            'title' => 'Pages CMS',
            'count' => $stats['pages'],
            'meta' => $stats['published_pages'] . ' publiées',
            'description' => 'Pages institutionnelles et contenus éditoriaux.',
            'href' => route('admin.cms.pages.index'),
            'create_href' => route('admin.cms.pages.create'),
            'tone' => 'border-sky-200 bg-sky-50 text-sky-700',
        ],
        [
            'title' => 'Pays',
            'count' => $stats['countries'] ?? 0,
            'meta' => 'Référentiel géographique',
            'description' => 'Base utilisée par les villes et les banques.',
            'href' => route('admin.cms.countries.index'),
            'create_href' => route('admin.cms.countries.create'),
            'tone' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
        ],
        [
            'title' => 'Villes',
            'count' => $stats['cities'],
            'meta' => 'Données locales',
            'description' => 'Villes utilisées par les utilisateurs et les enseignes.',
            'href' => route('admin.cms.cities.index'),
            'create_href' => route('admin.cms.cities.create'),
            'tone' => 'border-violet-200 bg-violet-50 text-violet-700',
        ],
        [
            'title' => 'Bannières pub',
            'count' => $stats['ad_banners'] ?? 0,
            'meta' => 'Home mobile',
            'description' => 'Bannières promotionnelles affichées sur l’accueil mobile.',
            'href' => route('admin.cms.ad-banners.index'),
            'create_href' => route('admin.cms.ad-banners.create'),
            'tone' => 'border-fuchsia-200 bg-fuchsia-50 text-fuchsia-700',
        ],
        [
            'title' => 'Banques',
            'count' => $stats['banks'],
            'meta' => 'Coordonnées de paiement',
            'description' => 'Banques disponibles pour les informations d’entreprise.',
            'href' => route('admin.cms.banks.index'),
            'create_href' => route('admin.cms.banks.create'),
            'tone' => 'border-amber-200 bg-amber-50 text-amber-700',
        ],
        [
            'title' => 'Marques',
            'count' => $stats['brands'] ?? 0,
            'meta' => 'Identité commerciale',
            'description' => 'Marques associées aux enseignes et visibles dans les listings.',
            'href' => route('admin.cms.brands.index'),
            'create_href' => route('admin.cms.brands.create'),
            'tone' => 'border-indigo-200 bg-indigo-50 text-indigo-700',
        ],
        [
            'title' => 'Méthodes de paiement',
            'count' => $stats['payment_methods'] ?? 0,
            'meta' => 'Parcours paiement',
            'description' => 'Modes de paiement disponibles et devise de référence.',
            'href' => route('admin.cms.payment-methods.index'),
            'create_href' => route('admin.cms.payment-methods.create'),
            'tone' => 'border-teal-200 bg-teal-50 text-teal-700',
        ],
        [
            'title' => 'Types d’enseigne',
            'count' => $stats['enseigne_types'] ?? 0,
            'meta' => 'Catalogue enseignes',
            'description' => 'Catégories visibles dans les fiches enseignes.',
            'href' => route('admin.cms.enseigne-types.index'),
            'create_href' => route('admin.cms.enseigne-types.create'),
            'tone' => 'border-rose-200 bg-rose-50 text-rose-700',
        ],
        [
            'title' => 'Types de panier',
            'count' => $stats['panier_types'] ?? 0,
            'meta' => 'Catalogue paniers',
            'description' => 'Catégories utilisées à la création des paniers.',
            'href' => route('admin.cms.panier-types.index'),
            'create_href' => route('admin.cms.panier-types.create'),
            'tone' => 'border-cyan-200 bg-cyan-50 text-cyan-700',
        ],
    ];

    $totalReferences =
        ($stats['countries'] ?? 0) +
        ($stats['cities'] ?? 0) +
        ($stats['ad_banners'] ?? 0) +
        ($stats['banks'] ?? 0) +
        ($stats['brands'] ?? 0) +
        ($stats['payment_methods'] ?? 0) +
        ($stats['enseigne_types'] ?? 0) +
        ($stats['panier_types'] ?? 0);
@endphp

@section('content')
    <div class="mx-auto max-w-7xl space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-5">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Administration CMS</p>
                        <h1 class="mt-2 text-2xl font-semibold text-slate-900">Contenu et référentiels</h1>
                        <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-600">
                            Gérez les pages institutionnelles et les référentiels structurants utilisés par
                            l’application et l’administration.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.cms.pages.create') }}"
                            class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                            Nouvelle page
                        </a>
                        <a href="{{ route('admin.cms.cities.create') }}"
                            class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Nouvelle ville
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-px bg-slate-200 md:grid-cols-3">
                <div class="bg-slate-50 px-6 py-5">
                    <p class="text-sm font-medium text-slate-500">Pages publiées</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $stats['published_pages'] }}</p>
                </div>
                <div class="bg-slate-50 px-6 py-5">
                    <p class="text-sm font-medium text-slate-500">Référentiels actifs</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $totalReferences }}</p>
                </div>
                <div class="bg-slate-50 px-6 py-5">
                    <p class="text-sm font-medium text-slate-500">Modules gérés</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900">{{ count($modules) }}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[1.5fr_0.7fr]">
            <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h2 class="text-lg font-semibold text-slate-900">Modules disponibles</h2>
                    <p class="mt-1 text-sm text-slate-500">Accès direct aux espaces de gestion.</p>
                </div>

                <div class="divide-y divide-slate-200">
                    @foreach ($modules as $module)
                        <div class="flex flex-col gap-5 px-6 py-5 lg:flex-row lg:items-center lg:justify-between">
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-3">
                                    <h3 class="text-base font-semibold text-slate-900">{{ $module['title'] }}</h3>
                                    <span class="inline-flex rounded-full border px-2.5 py-1 text-xs font-semibold {{ $module['tone'] }}">
                                        {{ $module['meta'] }}
                                    </span>
                                </div>
                                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $module['description'] }}</p>
                            </div>

                            <div class="flex items-center gap-4 lg:justify-end">
                                <div class="min-w-20 text-left lg:text-right">
                                    <p class="text-2xl font-semibold text-slate-900">{{ $module['count'] }}</p>
                                    <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Entrées</p>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ $module['href'] }}"
                                        class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                        Ouvrir
                                    </a>
                                    <a href="{{ $module['create_href'] }}"
                                        class="inline-flex items-center rounded-xl bg-slate-900 px-3 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                                        Ajouter
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-900">Raccourcis</h2>
                    <div class="mt-4 space-y-3">
                        <a href="{{ route('admin.cms.pages.index') }}"
                            class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                            <span>Pages CMS</span>
                            <span class="text-slate-400">{{ $stats['pages'] }}</span>
                        </a>
                        <a href="{{ route('admin.cms.countries.index') }}"
                            class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                            <span>Pays</span>
                            <span class="text-slate-400">{{ $stats['countries'] ?? 0 }}</span>
                        </a>
                        <a href="{{ route('admin.cms.ad-banners.index') }}"
                            class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                            <span>Bannières pub</span>
                            <span class="text-slate-400">{{ $stats['ad_banners'] ?? 0 }}</span>
                        </a>
                        <a href="{{ route('admin.cms.banks.index') }}"
                            class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                            <span>Banques</span>
                            <span class="text-slate-400">{{ $stats['banks'] }}</span>
                        </a>
                        <a href="{{ route('admin.cms.brands.index') }}"
                            class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                            <span>Marques</span>
                            <span class="text-slate-400">{{ $stats['brands'] ?? 0 }}</span>
                        </a>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-900">Règles métier</h2>
                    <div class="mt-4 space-y-4 text-sm leading-6 text-slate-600">
                        <p>Les suppressions restent bloquées quand un référentiel est déjà utilisé par des données actives.</p>
                        <p>Les modifications faites ici impactent directement les formulaires d’administration et l’application mobile.</p>
                        <p>Ce module reste réservé au niveau super-administrateur.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

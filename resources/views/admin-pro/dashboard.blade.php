@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

@section('content')
    <div class="space-y-6">
        <div class="admin-card p-6">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Bonjour, {{ auth()?->user()?->full_name ?? 'Admin' }}
                    </h1>
                    <p class="mt-1 text-sm text-slate-600">
                        Vue d'ensemble des commandes, transactions et enseignes de Save Me.
                    </p>
                </div>
                <div class="text-sm text-slate-500">
                    {{ now()->translatedFormat('l d F Y') }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-6">
            <x-admin.stats-card title="Commandes livrées" :value="number_format($stats['orders_livred_count'] ?? 0)" color="blue"
                :href="route('admin.orders.index', ['status' => 'delivered'])" button-text="Voir les commandes">
                <x-slot name="icon">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />
                    </svg>
                </x-slot>
            </x-admin.stats-card>

            <x-admin.stats-card title="Commandes confirmées" :value="number_format($stats['orders_confirmed_count'] ?? 0)" color="green"
                :href="route('admin.orders.index', ['status' => 'confirmed'])" button-text="Voir les commandes">
                <x-slot name="icon">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </x-slot>
            </x-admin.stats-card>

            <x-admin.stats-card title="Transactions réussies" :value="number_format($stats['successful_transactions'] ?? 0)" color="emerald"
                :href="route('admin.transactions.index')" button-text="Voir les transactions">
                <x-slot name="icon">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h4m-4 4h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </x-slot>
            </x-admin.stats-card>

            <x-admin.stats-card title="Revenu total" :value="number_format((float) ($stats['total_revenue'] ?? 0), 2) . ' MAD'" color="amber"
                :href="route('admin.transactions.index')" button-text="Ouvrir les paiements">
                <x-slot name="icon">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2m-7-4h14" />
                    </svg>
                </x-slot>
            </x-admin.stats-card>

            <x-admin.stats-card title="Enseignes partenaires" :value="number_format($stats['total_enseignes'] ?? 0)" color="violet"
                :href="route('admin.enseignes.index')" button-text="Voir les enseignes">
                <x-slot name="icon">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4" />
                    </svg>
                </x-slot>
            </x-admin.stats-card>

            <x-admin.stats-card title="Paniers actifs" :value="number_format($stats['total_paniers'] ?? 0)" color="rose"
                :href="route('admin.paniers.index')" button-text="Voir les paniers">
                <x-slot name="icon">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 8h14l-1 11H6L5 8zm2-3h10l1 3H6l1-3z" />
                    </svg>
                </x-slot>
            </x-admin.stats-card>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="admin-card p-6 xl:col-span-2">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-slate-900">Actions rapides</h2>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <x-admin.button href="{{ route('admin.paniers.create') }}" variant="primary" class="justify-center">
                        Ajouter un panier
                    </x-admin.button>

                    <x-admin.button href="{{ route('admin.enseignes.create') }}" variant="success" class="justify-center">
                        Ajouter une enseigne
                    </x-admin.button>

                    <x-admin.button href="{{ route('admin.analytics.index') }}" variant="outline" class="justify-center">
                        Voir les analytics
                    </x-admin.button>

                    <x-admin.button href="{{ route('admin.users.index') }}" variant="secondary" class="justify-center">
                        Gérer les utilisateurs
                    </x-admin.button>
                </div>
            </div>

            <div class="admin-card p-6">
                <h2 class="text-lg font-semibold text-slate-900">Écosystème Save Me</h2>
                <div class="mt-5 space-y-4">
                    <div class="flex items-center justify-between rounded-lg border border-slate-200 px-4 py-3">
                        <span class="text-sm text-slate-600">Utilisateurs</span>
                        <span class="text-lg font-semibold text-slate-900">{{ number_format($stats['total_users'] ?? 0) }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-lg border border-slate-200 px-4 py-3">
                        <span class="text-sm text-slate-600">Professionnels</span>
                        <span class="text-lg font-semibold text-slate-900">{{ number_format($stats['total_professionals'] ?? 0) }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-lg border border-slate-200 px-4 py-3">
                        <span class="text-sm text-slate-600">Enseignes</span>
                        <span class="text-lg font-semibold text-slate-900">{{ number_format($stats['total_enseignes'] ?? 0) }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-lg border border-slate-200 px-4 py-3">
                        <span class="text-sm text-slate-600">Paniers</span>
                        <span class="text-lg font-semibold text-slate-900">{{ number_format($stats['total_paniers'] ?? 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-card p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-900">Santé asynchrone</h2>
                @role('SUPERADMIN')
                    <a href="{{ route('admin.monitoring.async.index') }}"
                        class="px-3 py-1.5 text-xs font-medium rounded-md border border-slate-300 text-slate-700 hover:bg-slate-100">
                        Ouvrir le monitoring
                    </a>
                @endrole
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-5">
                <div class="rounded-lg border border-slate-200 p-4">
                    <p class="text-xs text-slate-500">Webhooks échoués</p>
                    <p class="mt-1 text-xl font-semibold text-red-600">{{ number_format($asyncHealth['failed_webhooks'] ?? 0) }}</p>
                </div>
                <div class="rounded-lg border border-slate-200 p-4">
                    <p class="text-xs text-slate-500">Webhooks bloqués</p>
                    <p class="mt-1 text-xl font-semibold text-amber-600">{{ number_format($asyncHealth['stuck_webhooks'] ?? 0) }}</p>
                </div>
                <div class="rounded-lg border border-slate-200 p-4">
                    <p class="text-xs text-slate-500">Rapports échoués</p>
                    <p class="mt-1 text-xl font-semibold text-red-600">{{ number_format($asyncHealth['failed_reports'] ?? 0) }}</p>
                </div>
                <div class="rounded-lg border border-slate-200 p-4">
                    <p class="text-xs text-slate-500">Rapports bloqués</p>
                    <p class="mt-1 text-xl font-semibold text-amber-600">{{ number_format($asyncHealth['stuck_reports'] ?? 0) }}</p>
                </div>
                <div class="rounded-lg border border-slate-200 p-4">
                    <p class="text-xs text-slate-500">Total incidents</p>
                    <p class="mt-1 text-xl font-semibold {{ ($asyncHealth['total_issues'] ?? 0) > 0 ? 'text-red-600' : 'text-green-600' }}">
                        {{ number_format($asyncHealth['total_issues'] ?? 0) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <div class="admin-card">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">Paniers récents</h3>
                </div>
                <div class="divide-y divide-slate-200">
                    @forelse($recentPaniers ?? [] as $panier)
                        <div class="px-6 py-4 hover:bg-slate-50/70">
                            <div class="flex items-center justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-slate-900 truncate">{{ $panier->name }}</p>
                                    <p class="mt-1 text-xs text-slate-600">
                                        {{ $panier->enseigne?->name ?? 'Sans enseigne' }} • {{ number_format((float) $panier->price, 2) }} MAD
                                    </p>
                                    <p class="mt-1 text-xs text-slate-500">{{ $panier->created_at?->diffForHumans() }}</p>
                                </div>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $panier->status?->color() }}">
                                    {{ $panier->status?->label() }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-10 text-center text-sm text-slate-500">Aucun panier récent.</div>
                    @endforelse
                </div>
            </div>

            <div class="admin-card">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">Transactions récentes</h3>
                </div>
                <div class="divide-y divide-slate-200">
                    @forelse($recentTransactions ?? [] as $transaction)
                        <div class="px-6 py-4 hover:bg-slate-50/70">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-slate-900">
                                        {{ $transaction->transaction_stripe_id ?? $transaction->uuid }}
                                    </p>
                                    <p class="mt-1 text-xs text-slate-600">
                                        {{ $transaction->enseigne?->name ?? 'Sans enseigne' }} •
                                        {{ $transaction->command?->user?->full_name ?? 'Client inconnu' }}
                                    </p>
                                    <p class="mt-1 text-xs text-slate-500">{{ $transaction->created_at?->diffForHumans() }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-emerald-600">{{ number_format((float) $transaction->price, 2) }} MAD</p>
                                    @if ($transaction->transaction_stripe_id)
                                        <a href="{{ getStripePaymentIntentDashboardUrl($transaction->transaction_stripe_id) }}"
                                            target="_blank"
                                            class="mt-1 inline-flex text-xs text-sky-600 hover:text-sky-700">
                                            Voir Stripe
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-10 text-center text-sm text-slate-500">Aucune transaction récente.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <div class="admin-card">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">Commandes récentes</h3>
                </div>
                <div class="divide-y divide-slate-200">
                    @forelse($recentOrders ?? [] as $order)
                        <div class="px-6 py-4 hover:bg-slate-50/70">
                            <div class="flex items-center justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-slate-900">{{ $order->command_number }}</p>
                                    <p class="mt-1 text-xs text-slate-600">
                                        {{ $order->panier?->name ?? 'Panier inconnu' }} •
                                        {{ $order->user?->full_name ?? 'Client inconnu' }}
                                    </p>
                                    <p class="mt-1 text-xs text-slate-500">{{ $order->created_at?->diffForHumans() }}</p>
                                </div>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $order->status?->color() }}">
                                    {{ $order->status?->label() }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-10 text-center text-sm text-slate-500">Aucune commande récente.</div>
                    @endforelse
                </div>
            </div>

            <div class="admin-card">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">Nouvelles enseignes</h3>
                </div>
                <div class="divide-y divide-slate-200">
                    @forelse($recentEnseignes ?? [] as $enseigne)
                        <div class="px-6 py-4 hover:bg-slate-50/70">
                            <div class="flex items-center justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-slate-900">{{ $enseigne->name }}</p>
                                    <p class="mt-1 text-xs text-slate-600">
                                        {{ $enseigne->city?->name ?? 'Ville non définie' }} •
                                        {{ $enseigne->user?->full_name ?? 'Professionnel inconnu' }}
                                    </p>
                                    <p class="mt-1 text-xs text-slate-500">{{ $enseigne->created_at?->diffForHumans() }}</p>
                                </div>
                                <a href="{{ route('admin.enseignes.show', $enseigne) }}"
                                    class="inline-flex rounded-md border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100">
                                    Ouvrir
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-10 text-center text-sm text-slate-500">Aucune enseigne récente.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

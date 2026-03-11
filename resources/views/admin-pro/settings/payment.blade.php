@extends('layouts.admin')

@section('title', 'Paramètres de Paiement')
@section('page-title', 'Paramètres de Paiement')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Paramètres de Paiement</h1>
                <p class="mt-1 text-sm text-slate-600">Configuration des méthodes de paiement</p>
            </div>
            <x-admin.button href="{{ route('admin.settings.index') }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour
            </x-admin.button>
        </div>

        <!-- Navigation Tabs -->
        @include('admin.settings.partials.navigation')

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Configuration des Paiements
                </h2>
            </div>

            <form action="{{ route('admin.settings.payment.update') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                @honeypot

                <div class="space-y-6">
                    <!-- Stripe Configuration -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Configuration Stripe
                            </h3>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-slate-600">Activer Stripe</span>
                                <x-admin.setting-field name="stripe_enabled" type="toggle" :value="$settings->stripe_enabled" />
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="rounded-lg border border-slate-200 p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-semibold text-slate-900">Clés Test / Local</h4>
                                    <span class="text-xs text-slate-500">Utilisées hors production</span>
                                </div>
                                <div class="space-y-4">
                                    <x-admin.setting-field name="stripe_test_public_key"
                                        label="Clé Publique Stripe (Test)" type="text"
                                        :value="$settings->stripe_test_public_key ?? $settings->stripe_public_key" placeholder="pk_test_..."
                                        help="Clé publique Stripe pour local/test" />

                                    <x-admin.setting-field name="stripe_test_secret_key"
                                        label="Clé Secrète Stripe (Test)" type="password"
                                        :value="$settings->stripe_test_secret_key ?? $settings->stripe_secret_key" placeholder="sk_test_..."
                                        help="Clé secrète Stripe pour local/test - Chiffrée" />

                                    <x-admin.setting-field name="stripe_test_webhook_secret"
                                        label="Secret Webhook (Test)" type="password"
                                        :value="$settings->stripe_test_webhook_secret ?? $settings->stripe_webhook_secret" placeholder="whsec_..."
                                        help="Secret webhook Stripe pour local/test - Chiffré" />
                                </div>
                            </div>

                            <div class="rounded-lg border border-slate-200 p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-semibold text-slate-900">Clés Production</h4>
                                    <span class="text-xs text-slate-500">Utilisées en environnement production</span>
                                </div>
                                <div class="space-y-4">
                                    <x-admin.setting-field name="stripe_live_public_key"
                                        label="Clé Publique Stripe (Live)" type="text" :value="$settings->stripe_live_public_key"
                                        placeholder="pk_live_..." help="Clé publique Stripe pour la production" />

                                    <x-admin.setting-field name="stripe_live_secret_key"
                                        label="Clé Secrète Stripe (Live)" type="password" :value="$settings->stripe_live_secret_key"
                                        placeholder="sk_live_..." help="Clé secrète Stripe pour la production - Chiffrée" />

                                    <x-admin.setting-field name="stripe_live_webhook_secret"
                                        label="Secret Webhook (Live)" type="password" :value="$settings->stripe_live_webhook_secret"
                                        placeholder="whsec_..." help="Secret webhook Stripe pour la production - Chiffré" />
                                </div>
                            </div>
                        </div>

                        <!-- Stripe Info Box -->
                        <div class="mt-4 bg-purple-50 border border-purple-200 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-purple-600 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="flex-1 text-sm text-purple-800">
                                    <p class="font-semibold mb-1">Configuration Webhook Stripe</p>
                                    <p class="mb-2">
                                        Environnement actif:
                                        <span class="font-semibold">{{ app()->environment('production') ? 'production (LIVE keys)' : app()->environment() . ' (TEST keys)' }}</span>
                                    </p>
                                    <p class="mb-2">URL du webhook à configurer dans votre dashboard Stripe :</p>
                                    <code
                                        class="block px-3 py-2 bg-white border border-purple-300 rounded text-xs font-mono">
                                        {{ route('stripe.webhook') }}
                                    </code>
                                    <p class="mt-2">Événements à écouter :
                                        <code class="text-xs">payment_intent.succeeded</code>,
                                        <code class="text-xs">payment_intent.payment_failed</code>,
                                        <code class="text-xs">charge.succeeded</code>,
                                        <code class="text-xs">charge.refunded</code>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- General Payment Settings -->
                    <div class="pt-6 border-t border-slate-200">
                        <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Paramètres Généraux
                        </h3>

                        <div class="max-w-md">
                            <x-admin.setting-field name="payment_currency" label="Devise de Paiement" type="select"
                                :value="$settings->payment_currency" required :options="[
                                    'MAD' => 'MAD - Dirham Marocain',
                                    'EUR' => 'EUR - Euro',
                                    'USD' => 'USD - Dollar US',
                                ]" help="Devise utilisée pour les paiements" />
                        </div>
                    </div>

                    <!-- Security Notice -->
                    <div class="pt-6 border-t border-slate-200">
                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-orange-600 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div class="flex-1">
                                    <h4 class="text-sm font-semibold text-orange-900 mb-1">Sécurité des Clés</h4>
                                    <p class="text-sm text-orange-800">
                                        Les clés secrètes sont automatiquement chiffrées avant d'être stockées dans la base
                                        de données.
                                        Ne partagez jamais vos clés Stripe avec qui que ce soit.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.settings.index') }}" variant="outline">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Annuler
                    </x-admin.button>
                    <x-admin.button type="submit">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Enregistrer les Modifications
                    </x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'Mode Maintenance')
@section('page-title', 'Mode Maintenance')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Mode Maintenance</h1>
                <p class="mt-1 text-sm text-slate-600">Configuration du mode maintenance de l'application</p>
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

        <!-- Status Card -->
        @if ($settings->enabled)
            <div class="bg-orange-50 border-2 border-orange-500 rounded-lg p-6">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-orange-900">⚠️ Mode Maintenance Activé</h3>
                        <p class="text-orange-800 mt-1">
                            Votre site est actuellement en mode maintenance. Les visiteurs verront le message configuré
                            ci-dessous.
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-green-50 border-2 border-green-500 rounded-lg p-6">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-green-900">✓ Site Opérationnel</h3>
                        <p class="text-green-800 mt-1">
                            Votre site est actuellement accessible à tous les visiteurs.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Configuration du Mode Maintenance
                </h2>
            </div>

            <form action="{{ route('admin.settings.maintenance.update') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Enable/Disable -->
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200">
                        <div>
                            <h3 class="text-sm font-semibold text-slate-900">Activer le Mode Maintenance</h3>
                            <p class="text-sm text-slate-600 mt-1">
                                Lorsqu'activé, seuls les administrateurs pourront accéder au site
                            </p>
                        </div>
                        <x-admin.setting-field name="enabled" type="toggle" :value="$settings->enabled" />
                    </div>

                    <!-- Maintenance Message -->
                    <div>
                        <x-admin.setting-field name="message" label="Message de Maintenance" type="textarea"
                            :value="$settings->message"
                            placeholder="Nous effectuons actuellement une maintenance. Nous serons de retour très bientôt."
                            rows="4" required help="Message affiché aux visiteurs pendant la maintenance" />
                    </div>

                    <!-- Allowed IPs -->
                    <div>
                        <x-admin.setting-field name="allowed_ips" label="Adresses IP Autorisées" type="textarea"
                            :value="is_array($settings->allowed_ips) ? implode(', ', $settings->allowed_ips) : ''" placeholder="127.0.0.1, 192.168.1.1" rows="3"
                            help="Liste d'adresses IP séparées par des virgules qui pourront accéder au site en mode maintenance" />
                    </div>

                    <!-- Retry After -->
                    <div class="max-w-md">
                        <x-admin.setting-field name="retry_after" label="Réessayer Après (secondes)" type="number"
                            :value="$settings->retry_after" placeholder="3600" help="Délai suggéré avant de réessayer (en secondes)" />
                    </div>

                    <!-- Info Box -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="flex-1 text-sm text-blue-800">
                                <p class="font-semibold mb-1">Informations Importantes</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Les utilisateurs connectés en tant qu'administrateur pourront toujours accéder au
                                        site</li>
                                    <li>Les adresses IP autorisées pourront accéder au site même sans être connectés</li>
                                    <li>Le message sera affiché sur une page dédiée aux visiteurs</li>
                                    <li>Les APIs REST pourront retourner un code 503 pendant la maintenance</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Preview -->
                    @if ($settings->enabled)
                        <div class="pt-6 border-t border-slate-200">
                            <h3 class="text-sm font-semibold text-slate-900 mb-4">Aperçu du Message</h3>
                            <div class="bg-slate-100 border-2 border-slate-300 rounded-lg p-8 text-center">
                                <div
                                    class="w-16 h-16 bg-orange-100 rounded-full mx-auto flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-slate-900 mb-2">Maintenance en cours</h2>
                                <p class="text-slate-600">{{ $settings->message }}</p>
                            </div>
                        </div>
                    @endif
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

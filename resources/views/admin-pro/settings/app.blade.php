@extends('layouts.admin')

@section('title', 'Paramètres de l\'Application')
@section('page-title', 'Paramètres de l\'Application')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Paramètres de l'Application</h1>
                <p class="mt-1 text-sm text-slate-600">Configuration du comportement de l'application</p>
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
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    Configuration de l'Application
                </h2>
            </div>

            <form action="{{ route('admin.settings.app.update') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Pagination & Display -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            Affichage & Pagination
                        </h3>

                        <div class="max-w-md">
                            <x-admin.setting-field name="items_per_page" label="Éléments par Page" type="number"
                                :value="$settings->items_per_page" placeholder="20" required
                                help="Nombre d'éléments affichés par page dans les listes" />
                        </div>
                    </div>

                    <!-- File Upload Settings -->
                    <div class="pt-6 border-t border-slate-200">
                        <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Téléchargement de Fichiers
                        </h3>

                        <div class="space-y-4">
                            <div class="max-w-md">
                                <x-admin.setting-field name="max_upload_size" label="Taille Maximale de Téléchargement (KB)"
                                    type="number" :value="$settings->max_upload_size" placeholder="2048" required
                                    help="Taille maximale en kilo-octets (2048 KB = 2 MB)" />
                            </div>

                            <div>
                                <label for="allowed_file_types" class="block text-sm font-medium text-slate-700 mb-2">
                                    Types de Fichiers Autorisés
                                </label>
                                <input type="text" name="allowed_file_types" id="allowed_file_types"
                                    value="{{ old('allowed_file_types', is_array($settings->allowed_file_types) ? implode(', ', $settings->allowed_file_types) : $settings->allowed_file_types) }}"
                                    placeholder="jpg, jpeg, png, gif, pdf, doc, docx"
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('allowed_file_types') border-red-500 @enderror">
                                <p class="mt-1 text-xs text-slate-500">Extensions de fichiers séparées par des virgules</p>
                                @error('allowed_file_types')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Info Box -->
                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-orange-600 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <div class="flex-1 text-sm text-orange-800">
                                        <p class="font-semibold mb-1">Limite du Serveur</p>
                                        <p>La taille maximale de téléchargement est également limitée par la configuration
                                            PHP de votre serveur (<code>upload_max_filesize</code> et
                                            <code>post_max_size</code>).
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security & Session -->
                    <div class="pt-6 border-t border-slate-200">
                        <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Sécurité & Session
                        </h3>

                        <div class="max-w-md">
                            <x-admin.setting-field name="session_timeout" label="Expiration de Session (minutes)"
                                type="number" :value="$settings->session_timeout" placeholder="120" required
                                help="Durée d'inactivité avant déconnexion automatique" />
                        </div>
                    </div>

                    <!-- User Registration -->
                    <div class="pt-6 border-t border-slate-200">
                        <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Inscription des Utilisateurs
                        </h3>

                        <div class="space-y-4">
                            <div
                                class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200">
                                <div>
                                    <h4 class="text-sm font-semibold text-slate-900">Autoriser les Inscriptions</h4>
                                    <p class="text-sm text-slate-600 mt-1">
                                        Permettre aux nouveaux utilisateurs de créer un compte
                                    </p>
                                </div>
                                <x-admin.setting-field name="enable_registration" type="toggle" :value="$settings->enable_registration" />
                            </div>

                            <div
                                class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200">
                                <div>
                                    <h4 class="text-sm font-semibold text-slate-900">Vérification d'Email Requise</h4>
                                    <p class="text-sm text-slate-600 mt-1">
                                        Les utilisateurs doivent vérifier leur email avant d'accéder au site
                                    </p>
                                </div>
                                <x-admin.setting-field name="email_verification_required" type="toggle"
                                    :value="$settings->email_verification_required" />
                            </div>
                        </div>
                    </div>

                    <!-- Current Configuration Summary -->
                    <div class="pt-6 border-t border-slate-200">
                        <h3 class="text-sm font-semibold text-slate-900 mb-4">Configuration Actuelle</h3>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-blue-900 font-medium">Éléments par page:</p>
                                    <p class="text-blue-700 font-mono">{{ $settings->items_per_page }}</p>
                                </div>
                                <div>
                                    <p class="text-blue-900 font-medium">Taille max upload:</p>
                                    <p class="text-blue-700 font-mono">{{ $settings->max_upload_size }} KB
                                        ({{ number_format($settings->max_upload_size / 1024, 2) }} MB)</p>
                                </div>
                                <div>
                                    <p class="text-blue-900 font-medium">Session timeout:</p>
                                    <p class="text-blue-700 font-mono">{{ $settings->session_timeout }} minutes</p>
                                </div>
                                <div>
                                    <p class="text-blue-900 font-medium">Types de fichiers:</p>
                                    <p class="text-blue-700 font-mono">
                                        {{ is_array($settings->allowed_file_types) ? count($settings->allowed_file_types) : 0 }}
                                        types autorisés</p>
                                </div>
                                <div>
                                    <p class="text-blue-900 font-medium">Inscription:</p>
                                    <p class="text-blue-700 font-mono">
                                        {{ $settings->enable_registration ? 'Activée' : 'Désactivée' }}</p>
                                </div>
                                <div>
                                    <p class="text-blue-900 font-medium">Vérification email:</p>
                                    <p class="text-blue-700 font-mono">
                                        {{ $settings->email_verification_required ? 'Requise' : 'Non requise' }}</p>
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

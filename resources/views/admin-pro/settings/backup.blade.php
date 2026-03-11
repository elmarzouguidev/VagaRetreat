@extends('layouts.admin')

@section('title', 'Sauvegarde & Logs')
@section('page-title', 'Sauvegarde & Logs')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Sauvegarde & Logs</h1>
                <p class="mt-1 text-sm text-slate-600">Configuration des sauvegardes automatiques et des logs</p>
            </div>
            <div class="flex gap-2">
                <x-admin.button href="{{ route('admin.settings.index') }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </x-admin.button>

                @can('edit-settings')
                    <form action="{{ route('admin.settings.backup.run') }}" method="POST" style="display: inline;">
                        @csrf
                        <x-admin.button type="submit">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Sauvegarder Maintenant
                        </x-admin.button>
                    </form>
                @endcan
            </div>
        </div>

        <!-- Navigation Tabs -->
        @include('admin.settings.partials.navigation')

        <form action="{{ route('admin.settings.backup.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Backup Configuration -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-green-100 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Configuration des Sauvegardes
                    </h2>
                    <p class="text-sm text-slate-600 mt-1">Automatisez les sauvegardes de votre application</p>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Enable Backup -->
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Activer les Sauvegardes Automatiques</p>
                            <p class="text-xs text-slate-600">Les sauvegardes seront effectuées automatiquement selon la
                                fréquence choisie</p>
                        </div>
                        <input type="checkbox" name="auto_backup_enabled" value="1"
                            {{ old('auto_backup_enabled', $settings->auto_backup_enabled) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Backup Settings Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-admin.setting-field name="backup_frequency" label="Fréquence de Sauvegarde" type="select"
                                :value="$settings->backup_frequency" required :options="[
                                    'daily' => 'Quotidienne',
                                    'weekly' => 'Hebdomadaire',
                                    'monthly' => 'Mensuelle',
                                ]"
                                help="À quelle fréquence effectuer les sauvegardes" />
                        </div>

                        <div>
                            <x-admin.setting-field name="backup_retention_days" label="Période de Rétention (jours)"
                                type="number" :value="$settings->backup_retention_days" placeholder="30" required
                                help="Nombre de jours avant suppression des anciennes sauvegardes" />
                        </div>

                        <div>
                            <x-admin.setting-field name="backup_time" label="Heure de Sauvegarde" type="text" :value="$settings->backup_time"
                                placeholder="02:00" required help="Heure d'exécution (format 24h: HH:MM)" />
                        </div>

                        <div>
                            <x-admin.setting-field name="max_backup_size_mb" label="Taille Max (MB)" type="number"
                                :value="$settings->max_backup_size_mb" placeholder="1024" required
                                help="Taille maximale d'une sauvegarde en MB" />
                        </div>

                        <div>
                            <x-admin.setting-field name="backup_storage_disk" label="Stockage" type="select" :value="$settings->backup_storage_disk"
                                :options="[
                                    'local' => 'Disque Local',
                                    's3' => 'Amazon S3',
                                    'dropbox' => 'Dropbox',
                                    'google' => 'Google Drive',
                                ]" help="Où stocker les sauvegardes" />
                        </div>

                        <div>
                            <x-admin.setting-field name="backup_path" label="Chemin de Sauvegarde" type="text"
                                :value="$settings->backup_path" placeholder="backups"
                                help="Chemin relatif pour stocker les sauvegardes" />
                        </div>
                    </div>

                    <!-- What to Backup -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-3">Éléments à Sauvegarder</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <label
                                class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                                <input type="checkbox" name="backup_include[]" value="database"
                                    {{ in_array('database', old('backup_include', $settings->backup_include)) ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Base de Données</p>
                                    <p class="text-xs text-slate-600">Tables et données</p>
                                </div>
                            </label>

                            <label
                                class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                                <input type="checkbox" name="backup_include[]" value="files"
                                    {{ in_array('files', old('backup_include', $settings->backup_include)) ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Fichiers de l'App</p>
                                    <p class="text-xs text-slate-600">Code source et configuration</p>
                                </div>
                            </label>

                            <label
                                class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                                <input type="checkbox" name="backup_include[]" value="media"
                                    {{ in_array('media', old('backup_include', $settings->backup_include)) ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Médias</p>
                                    <p class="text-xs text-slate-600">Images, documents uploadés</p>
                                </div>
                            </label>

                            <label
                                class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                                <input type="checkbox" name="backup_include[]" value="logs"
                                    {{ in_array('logs', old('backup_include', $settings->backup_include)) ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Logs</p>
                                    <p class="text-xs text-slate-600">Fichiers de logs</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Compression -->
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Compresser les Sauvegardes</p>
                            <p class="text-xs text-slate-600">Réduire la taille des fichiers de sauvegarde (ZIP)</p>
                        </div>
                        <input type="checkbox" name="compress_backups" value="1"
                            {{ old('compress_backups', $settings->compress_backups) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Schedule Info -->
                    <div id="schedule-info" class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="flex-1 text-sm text-blue-800">
                                <p class="font-semibold mb-1">Planification</p>
                                <p id="schedule-text">Prochaine sauvegarde:
                                    <strong>{{ $settings->backup_frequency === 'daily' ? 'Quotidienne' : ($settings->backup_frequency === 'weekly' ? 'Hebdomadaire' : 'Mensuelle') }}
                                        à {{ $settings->backup_time }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup Notifications -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-purple-100 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        Notifications de Sauvegarde
                    </h2>
                    <p class="text-sm text-slate-600 mt-1">Recevez des notifications sur l'état des sauvegardes</p>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <x-admin.setting-field name="backup_notification_email" label="Email de Notification" type="email"
                            :value="$settings->backup_notification_email" placeholder="admin@example.com" required
                            help="Adresse email pour recevoir les notifications" />
                    </div>

                    <div class="space-y-3">
                        <label
                            class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Notification de Succès</p>
                                <p class="text-xs text-slate-600">Email après chaque sauvegarde réussie</p>
                            </div>
                            <input type="checkbox" name="notify_on_backup_success" value="1"
                                {{ old('notify_on_backup_success', $settings->notify_on_backup_success) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                        </label>

                        <label
                            class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Notification d'Échec</p>
                                <p class="text-xs text-slate-600">Email en cas d'échec de sauvegarde (recommandé)</p>
                            </div>
                            <input type="checkbox" name="notify_on_backup_failure" value="1"
                                {{ old('notify_on_backup_failure', $settings->notify_on_backup_failure) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                        </label>
                    </div>
                </div>
            </div>

            <!-- Logging Configuration -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-orange-100 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Configuration des Logs
                    </h2>
                    <p class="text-sm text-slate-600 mt-1">Gérez les logs de l'application</p>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-admin.setting-field name="log_level" label="Niveau de Log" type="select" :value="$settings->log_level"
                                required :options="[
                                    'debug' => 'Debug (Tout)',
                                    'info' => 'Info (Recommandé)',
                                    'warning' => 'Warning (Avertissements)',
                                    'error' => 'Error (Erreurs uniquement)',
                                ]" help="Niveau de détail des logs" />
                        </div>

                        <div>
                            <x-admin.setting-field name="log_retention_days" label="Rétention des Logs (jours)" type="number"
                                :value="$settings->log_retention_days" placeholder="30" required
                                help="Durée de conservation des fichiers de logs" />
                        </div>
                    </div>

                    <!-- What to Log -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-3">Éléments à Logger</label>
                        <div class="space-y-3">
                            <label
                                class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Requêtes SQL</p>
                                    <p class="text-xs text-slate-600">Enregistrer toutes les requêtes de base de données
                                        (peut affecter les performances)</p>
                                </div>
                                <input type="checkbox" name="log_queries" value="1"
                                    {{ old('log_queries', $settings->log_queries) ? 'checked' : '' }}
                                    class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                            </label>

                            <label
                                class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Activités Utilisateurs</p>
                                    <p class="text-xs text-slate-600">Enregistrer les actions des utilisateurs (recommandé)
                                    </p>
                                </div>
                                <input type="checkbox" name="log_user_activities" value="1"
                                    {{ old('log_user_activities', $settings->log_user_activities) ? 'checked' : '' }}
                                    class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                            </label>

                            <label
                                class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Requêtes API</p>
                                    <p class="text-xs text-slate-600">Enregistrer les appels API entrants et sortants</p>
                                </div>
                                <input type="checkbox" name="log_api_requests" value="1"
                                    {{ old('log_api_requests', $settings->log_api_requests) ? 'checked' : '' }}
                                    class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                            </label>
                        </div>
                    </div>

                    <!-- Log Info -->
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-orange-600 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div class="flex-1 text-sm text-orange-800">
                                <p class="font-semibold mb-1">Performance</p>
                                <p>L'activation du logging des requêtes SQL peut affecter les performances de l'application.
                                    Utilisez cette option uniquement pour le débogage.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900">Actions Rapides</h2>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('admin.activity-logs.index') }}"
                            class="flex items-center gap-4 p-4 bg-slate-50 rounded-lg border border-slate-200 hover:bg-slate-100 transition">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Voir les Logs d'Activité</p>
                                <p class="text-xs text-slate-600">Consulter l'historique des activités</p>
                            </div>
                        </a>

                        @can('edit-settings')
                            <button type="button"
                                onclick="if(confirm('Êtes-vous sûr de vouloir nettoyer les anciennes sauvegardes?')) { window.location.href='{{ route('admin.settings.backup.cleanup') }}'; }"
                                class="flex items-center gap-4 p-4 bg-slate-50 rounded-lg border border-slate-200 hover:bg-slate-100 transition text-left">
                                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Nettoyer les Anciennes Sauvegardes</p>
                                    <p class="text-xs text-slate-600">Supprimer les sauvegardes expirées</p>
                                </div>
                            </button>
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pb-6">
                <x-admin.button href="{{ route('admin.settings.index') }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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
@endsection

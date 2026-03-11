@extends('layouts.admin')

@section('title', 'Paramètres')
@section('page-title', 'Paramètres du Profil')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <x-admin.button href="{{ route('admin.profile.index') }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour au Profil
            </x-admin.button>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Des erreurs sont survenues :</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.profile.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Account Settings -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Paramètres du Compte
                        </h2>
                        <p class="mt-1 text-sm text-slate-600">Gérez les paramètres et préférences de votre compte.</p>
                    </div>

                    <div class="p-6 space-y-4">
                        <!-- Email Notifications -->
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200">
                            <div class="flex items-start gap-3">
                                <div class="mt-1">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-slate-900">Notifications par E-mail</h4>
                                    <p class="text-sm text-slate-600 mt-0.5">Recevez des notifications par e-mail pour les
                                        mises à jour importantes</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="email_notifications" name="email_notifications"
                                        value="1" class="sr-only peer"
                                        {{ old('email_notifications', $user->email_notifications) ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-slate-700" id="email_notifications_label">
                                        {{ old('email_notifications', $user->email_notifications) ? 'Activé' : 'Désactivé' }}
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Two-Factor Authentication -->
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200">
                            <div class="flex items-start gap-3">
                                <div class="mt-1">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-slate-900">Authentification à Deux Facteurs</h4>
                                    <p class="text-sm text-slate-600 mt-0.5">Ajoutez une couche de sécurité supplémentaire à
                                        votre compte</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->two_factor_secret ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-800' }}">
                                    @if ($user->two_factor_secret)
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                    {{ $user->two_factor_secret ? 'Activé' : 'Désactivé' }}
                                </span>
                                <a href="{{ route('admin.two-factor.index') }}"
                                    class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                    Configurer
                                </a>
                            </div>
                        </div>

                        <!-- Session Management -->
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200">
                            <div class="flex items-start gap-3">
                                <div class="mt-1">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-slate-900">Gestion des Sessions</h4>
                                    <p class="text-sm text-slate-600 mt-0.5">Gérez vos sessions actives sur différents
                                        appareils</p>
                                </div>
                            </div>
                            <x-admin.button type="button" variant="outline" size="sm">
                                Voir les Sessions
                            </x-admin.button>
                        </div>
                    </div>
                </div>

                <!-- Privacy Settings -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Paramètres de Confidentialité
                        </h2>
                        <p class="mt-1 text-sm text-slate-600">Contrôlez qui peut voir vos informations.</p>
                    </div>

                    <div class="p-6 space-y-4">
                        <!-- Profile Visibility -->
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200">
                            <div class="flex items-start gap-3">
                                <div class="mt-1">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-slate-900">Visibilité du Profil</h4>
                                    <p class="text-sm text-slate-600 mt-0.5">Contrôlez qui peut voir vos informations de
                                        profil</p>
                                </div>
                            </div>
                            <select name="profile_visibility"
                                class="px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm">
                                <option value="public"
                                    {{ old('profile_visibility', $user->profile_visibility) === 'public' ? 'selected' : '' }}>
                                    Public</option>
                                <option value="private"
                                    {{ old('profile_visibility', $user->profile_visibility) === 'private' ? 'selected' : '' }}>
                                    Privé</option>
                                <option value="friends_only"
                                    {{ old('profile_visibility', $user->profile_visibility) === 'friends_only' ? 'selected' : '' }}>
                                    Amis Uniquement</option>
                            </select>
                        </div>

                        <!-- Activity Status -->
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200">
                            <div class="flex items-start gap-3">
                                <div class="mt-1">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-slate-900">Statut d'Activité</h4>
                                    <p class="text-sm text-slate-600 mt-0.5">Afficher quand vous êtes actif sur la
                                        plateforme</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="activity_status" name="activity_status" value="1"
                                        class="sr-only peer"
                                        {{ old('activity_status', $user->activity_status) ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-slate-700" id="activity_status_label">
                                        {{ old('activity_status', $user->activity_status) ? 'Activé' : 'Désactivé' }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Management -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                            </svg>
                            Gestion des Données
                        </h2>
                        <p class="mt-1 text-sm text-slate-600">Exportez ou supprimez vos données.</p>
                    </div>

                    <div class="p-6 space-y-4">
                        <!-- Export Data -->
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200">
                            <div class="flex items-start gap-3">
                                <div class="mt-1">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-slate-900">Exporter les Données</h4>
                                    <p class="text-sm text-slate-600 mt-0.5">Téléchargez une copie de toutes vos données
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('admin.profile.export-data') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Exporter
                            </a>
                        </div>

                        <!-- Delete Account -->
                        <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-200">
                            <div class="flex items-start gap-3">
                                <div class="mt-1">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-1.964-1.333-2.732 0L3.732 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-red-900">Supprimer le Compte</h4>
                                    <p class="text-sm text-red-700 mt-0.5">Supprimez définitivement votre compte et toutes
                                        vos données</p>
                                </div>
                            </div>
                            <button type="button" onclick="confirmDeleteAccount()"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Save Settings -->
                <div class="flex justify-end gap-3">
                    <x-admin.button href="{{ route('admin.profile.index') }}" variant="outline">
                        Annuler
                    </x-admin.button>
                    <x-admin.button type="submit">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Enregistrer les Paramètres
                    </x-admin.button>
                </div>
            </div>
        </form>
    </div>

    <!-- Delete Account Confirmation Modal -->
    <div id="deleteAccountModal"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50"
        onclick="if(event.target === this) closeDeleteModal()">
        <div class="relative top-20 mx-auto p-0 w-full max-w-md">
            <div class="bg-white rounded-lg shadow-xl border border-slate-200">
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-1.964-1.333-2.732 0L3.732 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 text-center mt-4">Supprimer le Compte</h3>
                    <p class="text-sm text-slate-600 text-center mt-2 px-4">
                        Êtes-vous sûr de vouloir supprimer définitivement votre compte ? Cette action est irréversible et
                        toutes vos données seront perdues.
                    </p>
                </div>
                <div class="px-6 pb-6 space-y-3">
                    <button id="confirmDelete"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Oui, Supprimer Mon Compte
                    </button>
                    <button onclick="closeDeleteModal()"
                        class="w-full px-4 py-3 bg-white border border-slate-300 rounded-lg font-medium text-slate-700 hover:bg-slate-50 transition">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmDeleteAccount() {
                document.getElementById('deleteAccountModal').classList.remove('hidden');
            }

            function closeDeleteModal() {
                document.getElementById('deleteAccountModal').classList.add('hidden');
            }

            document.getElementById('confirmDelete').addEventListener('click', function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('admin.profile.delete-account') }}';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            });

            // Update toggle labels
            document.addEventListener('DOMContentLoaded', function() {
                const toggles = [{
                        checkbox: 'email_notifications',
                        label: 'email_notifications_label'
                    },
                    {
                        checkbox: 'activity_status',
                        label: 'activity_status_label'
                    }
                ];

                toggles.forEach(function(toggle) {
                    const checkbox = document.getElementById(toggle.checkbox);
                    const label = document.getElementById(toggle.label);

                    if (checkbox && label) {
                        checkbox.addEventListener('change', function() {
                            label.textContent = this.checked ? 'Activé' : 'Désactivé';
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection

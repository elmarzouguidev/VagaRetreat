@extends('layouts.admin')

@section('title', 'Paramètres Email')
@section('page-title', 'Paramètres Email')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Paramètres Email</h1>
                <p class="mt-1 text-sm text-slate-600">Configuration de l'envoi d'emails</p>
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
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Configuration SMTP
                </h2>
            </div>

            <form action="{{ route('admin.settings.email.update') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- SMTP Configuration -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                            </svg>
                            Serveur Mail
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-admin.setting-field name="mail_mailer" label="Driver Mail" type="select"
                                    :value="$settings->mail_mailer" required :options="[
                                        'smtp' => 'SMTP',
                                        'sendmail' => 'Sendmail',
                                        'mailgun' => 'Mailgun',
                                        'ses' => 'Amazon SES',
                                        'resend' => 'resend.com',
                                    ]" help="Type de serveur mail" />
                            </div>

                            <div>
                                <x-admin.setting-field name="mail_host" label="Hôte SMTP" type="text" :value="$settings->mail_host"
                                    placeholder="smtp.gmail.com" required help="Adresse du serveur SMTP" />
                            </div>

                            <div>
                                <x-admin.setting-field name="mail_port" label="Port SMTP" type="number" :value="$settings->mail_port"
                                    placeholder="587" required help="Port du serveur (587, 465, 25)" />
                            </div>

                            <div>
                                <x-admin.setting-field name="mail_encryption" label="Chiffrement" type="select"
                                    :value="$settings->mail_encryption" :options="[
                                        '' => 'Aucun',
                                        'tls' => 'TLS',
                                        'ssl' => 'SSL',
                                    ]" help="Type de chiffrement" />
                            </div>

                            <div>
                                <x-admin.setting-field name="mail_username" label="Nom d'utilisateur" type="text"
                                    :value="$settings->mail_username" placeholder="votre.email@example.com" help="Identifiant SMTP" />
                            </div>

                            <div>
                                <x-admin.setting-field name="mail_password" label="Mot de Passe" type="password"
                                    :value="$settings->mail_password" placeholder="••••••••" help="Mot de passe SMTP (chiffré)" />
                            </div>
                        </div>
                    </div>

                    <!-- Sender Information -->
                    <div class="pt-6 border-t border-slate-200">
                        <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                            Expéditeur
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-admin.setting-field name="mail_from_address" label="Email d'Expédition" type="email"
                                    :value="$settings->mail_from_address" placeholder="noreply@example.com" required
                                    help="Adresse email d'envoi par défaut" />
                            </div>

                            <div>
                                <x-admin.setting-field name="mail_from_name" label="Nom d'Expédition" type="text"
                                    :value="$settings->mail_from_name" placeholder="Mon Application" required
                                    help="Nom affiché comme expéditeur" />
                            </div>
                        </div>
                    </div>

                    <!-- Test Email -->
                    <div class="pt-6 border-t border-slate-200">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="flex-1">
                                    <h4 class="text-sm font-semibold text-blue-900 mb-2">Tester la Configuration</h4>
                                    <p class="text-sm text-blue-800 mb-3">
                                        Envoyez un email de test pour vérifier que votre configuration fonctionne
                                        correctement.
                                    </p>
                                    <div class="flex gap-3">
                                        <input type="email" id="test_email" placeholder="email@example.com"
                                            class="flex-1 px-3 py-2 text-sm border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <button type="button" onclick="sendTestEmail()"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                                            Envoyer Test
                                        </button>
                                    </div>
                                    <div id="test-result" class="mt-2 text-sm"></div>
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

    @push('scripts')
        <script>
            async function sendTestEmail() {
                const email = document.getElementById('test_email').value;
                const resultDiv = document.getElementById('test-result');

                if (!email) {
                    resultDiv.innerHTML = '<p class="text-red-600">Veuillez entrer une adresse email.</p>';
                    return;
                }

                resultDiv.innerHTML = '<p class="text-blue-600">Envoi en cours...</p>';

                try {
                    const response = await fetch('{{ route('admin.settings.email.test') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            email
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        resultDiv.innerHTML = '<p class="text-green-600">✓ ' + data.message + '</p>';
                    } else {
                        resultDiv.innerHTML = '<p class="text-red-600">✗ ' + data.message + '</p>';
                    }
                } catch (error) {
                    resultDiv.innerHTML = '<p class="text-red-600">✗ Erreur lors de l\'envoi.</p>';
                }
            }
        </script>
    @endpush
@endsection

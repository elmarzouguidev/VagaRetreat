@extends('layouts.admin')

@section('title', 'Authentification à deux facteurs')
@section('page-title', 'Authentification à deux facteurs')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Header Info -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-6">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-slate-900 mb-1">
                        Sécurité renforcée avec 2FA
                    </h3>
                    <p class="text-sm text-slate-700">
                        L'authentification à deux facteurs ajoute une couche de sécurité supplémentaire à votre compte.
                        En plus de votre mot de passe, vous devrez entrer un code généré par votre application
                        d'authentification.
                    </p>
                </div>
            </div>
        </div>

        @if ($enabled)
            <!-- 2FA Enabled -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200 bg-green-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-green-500 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-green-900">2FA activée</h2>
                                <p class="text-sm text-green-700">Votre compte est protégé</p>
                            </div>
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Actif
                        </span>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Recovery Codes -->
                    <div class="flex items-start justify-between p-4 bg-slate-50 rounded-lg border border-slate-200">
                        <div class="flex items-start gap-4">
                            <div class="p-2 bg-amber-100 rounded-lg">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-medium text-slate-900 mb-1">Codes de récupération</h3>
                                <p class="text-sm text-slate-600">
                                    Conservez vos codes de récupération en lieu sûr. Ils vous permettent d'accéder à votre
                                    compte si vous perdez votre téléphone.
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('admin.two-factor.recovery') }}"
                            class="inline-flex items-center px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition text-sm font-medium whitespace-nowrap">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Voir les codes
                        </a>
                    </div>

                    <!-- Disable 2FA -->
                    <div class="border-t border-slate-200 pt-6">
                        <form action="{{ route('admin.two-factor.disable') }}" method="POST"
                            onsubmit="return confirm('Êtes-vous sûr de vouloir désactiver l\'authentification à deux facteurs ?');"
                            class="space-y-4">
                            @csrf
                            @method('DELETE')

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Confirmer avec votre mot de passe
                                </label>
                                <input type="password" name="password" required placeholder="Votre mot de passe"
                                    class="w-full max-w-md px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                class="inline-flex items-center px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Désactiver la 2FA
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <!-- 2FA Disabled -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200 bg-amber-50">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-amber-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-amber-900">2FA non activée</h2>
                            <p class="text-sm text-amber-700">Votre compte n'est pas protégé par la double authentification
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="font-semibold text-slate-900 mb-3">Comment ça marche ?</h3>
                        <ol class="space-y-3">
                            <li class="flex items-start gap-3">
                                <span
                                    class="flex-shrink-0 flex items-center justify-center w-6 h-6 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold">1</span>
                                <span class="text-sm text-slate-600">Installez une application d'authentification (Google
                                    Authenticator, Authy, etc.)</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span
                                    class="flex-shrink-0 flex items-center justify-center w-6 h-6 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold">2</span>
                                <span class="text-sm text-slate-600">Scannez le code QR avec votre application</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span
                                    class="flex-shrink-0 flex items-center justify-center w-6 h-6 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold">3</span>
                                <span class="text-sm text-slate-600">Entrez le code à 6 chiffres pour confirmer
                                    l'activation</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span
                                    class="flex-shrink-0 flex items-center justify-center w-6 h-6 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold">4</span>
                                <span class="text-sm text-slate-600">Sauvegardez vos codes de récupération en lieu
                                    sûr</span>
                            </li>
                        </ol>
                    </div>

                    <form action="{{ route('admin.two-factor.enable') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition font-medium shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Activer la 2FA
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <!-- Recommended Apps -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <h3 class="font-semibold text-slate-900 mb-4">Applications recommandées</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="https://support.google.com/accounts/answer/1066447" target="_blank"
                    class="flex items-center gap-3 p-4 border border-slate-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition group">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">G</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-slate-900 group-hover:text-blue-600">Google Authenticator</p>
                        <p class="text-xs text-slate-500">iOS & Android</p>
                    </div>
                </a>

                <a href="https://authy.com/download/" target="_blank"
                    class="flex items-center gap-3 p-4 border border-slate-200 rounded-lg hover:border-red-300 hover:bg-red-50 transition group">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">A</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-slate-900 group-hover:text-red-600">Authy</p>
                        <p class="text-xs text-slate-500">iOS, Android & Desktop</p>
                    </div>
                </a>

                <a href="https://www.microsoft.com/fr-fr/security/mobile-authenticator-app" target="_blank"
                    class="flex items-center gap-3 p-4 border border-slate-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition group">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">M</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-slate-900 group-hover:text-green-600">Microsoft Authenticator</p>
                        <p class="text-xs text-slate-500">iOS & Android</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection

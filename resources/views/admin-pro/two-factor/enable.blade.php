@extends('layouts.admin')

@section('title', 'Activer la 2FA')
@section('page-title', 'Activer l\'authentification à deux facteurs')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.two-factor.index') }}"
                class="inline-flex items-center text-sm text-slate-600 hover:text-slate-900">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour aux paramètres 2FA
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200 bg-blue-50">
                <h2 class="text-lg font-semibold text-blue-900">Configuration de la 2FA</h2>
                <p class="text-sm text-blue-700 mt-1">Suivez les étapes ci-dessous pour activer la double authentification
                </p>
            </div>

            <div class="p-6 space-y-8">
                <!-- Step 1: Scan QR Code -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span
                            class="flex items-center justify-center w-8 h-8 bg-blue-600 text-white rounded-full text-sm font-bold">1</span>
                        <h3 class="text-lg font-semibold text-slate-900">Scannez le code QR</h3>
                    </div>

                    <div
                        class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-lg p-8 text-center border border-slate-200">
                        <p class="text-sm text-slate-600 mb-6">
                            Utilisez votre application d'authentification pour scanner ce code QR
                        </p>

                        <div class="inline-block p-6 bg-white rounded-lg shadow-sm border-2 border-slate-200">
                            {!! $qrCode !!}
                        </div>

                        <details class="mt-6">
                            <summary class="text-sm text-blue-600 hover:text-blue-800 cursor-pointer font-medium">
                                Impossible de scanner ? Entrez manuellement
                            </summary>
                            <div class="mt-4 p-4 bg-white rounded-lg border border-slate-200">
                                <p class="text-xs text-slate-500 mb-2">Clé secrète:</p>
                                <code
                                    class="block px-4 py-3 bg-slate-900 text-green-400 rounded font-mono text-sm break-all">{{ $secret }}</code>
                                <button
                                    onclick="navigator.clipboard.writeText('{{ $secret }}'); this.textContent='Copié!'; setTimeout(() => this.textContent='Copier', 2000)"
                                    class="mt-3 text-xs text-blue-600 hover:text-blue-800 font-medium">
                                    Copier
                                </button>
                            </div>
                        </details>
                    </div>
                </div>

                <!-- Step 2: Enter Code -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span
                            class="flex items-center justify-center w-8 h-8 bg-blue-600 text-white rounded-full text-sm font-bold">2</span>
                        <h3 class="text-lg font-semibold text-slate-900">Confirmez avec un code</h3>
                    </div>

                    <form action="{{ route('admin.two-factor.confirm') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Entrez le code à 6 chiffres
                            </label>
                            <input type="text" name="code" inputmode="numeric" pattern="[0-9]{6}" maxlength="6"
                                placeholder="000000" autofocus required
                                class="w-full max-w-xs px-4 py-3 border border-slate-300 rounded-lg text-center text-2xl tracking-widest font-mono focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                            @error('code')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <p class="mt-2 text-sm text-slate-500">
                                Le code change toutes les 30 secondes
                            </p>
                        </div>

                        <div class="flex items-center gap-3 pt-4">
                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Confirmer et activer
                            </button>

                            <a href="{{ route('admin.two-factor.index') }}"
                                class="inline-flex items-center px-6 py-3 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition font-medium">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

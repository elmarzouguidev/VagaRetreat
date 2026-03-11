@extends('layouts.admin')

@section('title', 'Génération de Numéros')
@section('page-title', 'Génération de Numéros')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Génération de Numéros</h1>
                <p class="mt-1 text-sm text-slate-600">Configuration des formats de numérotation</p>
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

        <form action="{{ route('admin.settings.number-generation.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Commands Number Generation -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Numéros de Commandes
                    </h2>
                    <p class="text-sm text-slate-600 mt-1">Format: <code
                            class="px-2 py-0.5 bg-white rounded text-blue-600 font-mono">{{ commandSetting()->prefix }}{{ commandSetting()->delimiter }}0001{{ commandSetting()->suffix }}</code>
                    </p>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-admin.setting-field name="command_generator_type" label="Type de Génération" type="select"
                                :value="commandSetting()->generator_type" required :options="[
                                    'by_order' => 'Séquentiel (CMD-0001, CMD-0002...)',
                                    'by_random' => 'Aléatoire (584729384756...)',
                                ]" help="Méthode de génération des numéros" />
                        </div>

                        <div id="command-sequential-fields">
                            <x-admin.setting-field name="command_prefix" label="Préfixe" type="text" :value="commandSetting()->prefix"
                                placeholder="CMD" help="Préfixe du numéro (ex: CMD)" />
                        </div>

                        <div>
                            <x-admin.setting-field name="command_suffix" label="Suffixe" type="text" :value="commandSetting()->suffix"
                                placeholder="" help="Suffixe du numéro (optionnel)" />
                        </div>

                        <div>
                            <x-admin.setting-field name="command_delimiter" label="Séparateur" type="text"
                                :value="commandSetting()->delimiter" placeholder="-" help="Caractère de séparation (ex: -)" />
                        </div>

                        <div>
                            <x-admin.setting-field name="command_start" label="Numéro de Départ" type="number"
                                :value="commandSetting()->start" placeholder="1" help="Premier numéro de la séquence" />
                        </div>

                        <div>
                            <x-admin.setting-field name="command_digit" label="Nombre de Chiffres" type="number"
                                :value="commandSetting()->digit" placeholder="4" help="Nombre de chiffres (ex: 4 pour 0001)" />
                        </div>

                        <div>
                            <x-admin.setting-field name="command_pad_type" label="Type de Remplissage" type="select"
                                :value="commandSetting()->pad_type" :options="[
                                    '0' => 'Gauche (0001)',
                                    '1' => 'Droite (1000)',
                                    '2' => 'Les Deux (0100)',
                                ]" help="Position des zéros de remplissage" />
                        </div>
                    </div>

                    <!-- Preview -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm font-medium text-blue-900 mb-2">Aperçu du Format</p>
                        <p class="text-lg font-mono text-blue-700">
                            {{ commandSetting()->prefix ?? 'CMD' }}{{ commandSetting()->delimiter ?? '-' }}{{ str_pad(commandSetting()->start ?? 1, commandSetting()->digit ?? 4, '0', commandSetting()->pad_type ?? 0) }}{{ commandSetting()->suffix }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Paniers Number Generation -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-green-100 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Numéros de Paniers
                    </h2>
                    <p class="text-sm text-slate-600 mt-1">Format: <code
                            class="px-2 py-0.5 bg-white rounded text-green-600 font-mono">{{ panierSetting()->prefix }}{{ panierSetting()->delimiter }}0001{{ panierSetting()->suffix }}</code>
                    </p>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-admin.setting-field name="panier_generator_type" label="Type de Génération" type="select"
                                :value="panierSetting()->generator_type" required :options="[
                                    'by_order' => 'Séquentiel',
                                    'by_random' => 'Aléatoire',
                                ]" help="Méthode de génération" />
                        </div>

                        <div>
                            <x-admin.setting-field name="panier_prefix" label="Préfixe" type="text" :value="panierSetting()->prefix"
                                placeholder="PAN" />
                        </div>

                        <div>
                            <x-admin.setting-field name="panier_suffix" label="Suffixe" type="text" :value="panierSetting()->suffix" />
                        </div>

                        <div>
                            <x-admin.setting-field name="panier_delimiter" label="Séparateur" type="text"
                                :value="panierSetting()->delimiter" placeholder="-" />
                        </div>

                        <div>
                            <x-admin.setting-field name="panier_start" label="Numéro de Départ" type="number"
                                :value="panierSetting()->start" placeholder="1" />
                        </div>

                        <div>
                            <x-admin.setting-field name="panier_digit" label="Nombre de Chiffres" type="number"
                                :value="panierSetting()->digit" placeholder="4" />
                        </div>

                        <div>
                            <x-admin.setting-field name="panier_pad_type" label="Type de Remplissage" type="select"
                                :value="panierSetting()->pad_type" :options="[
                                    '0' => 'Gauche (0001)',
                                    '1' => 'Droite (1000)',
                                    '2' => 'Les Deux (0100)',
                                ]" />
                        </div>
                    </div>

                    <!-- Preview -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <p class="text-sm font-medium text-green-900 mb-2">Aperçu du Format</p>
                        <p class="text-lg font-mono text-green-700">
                            {{ panierSetting()->prefix ?? 'PAN' }}{{ panierSetting()->delimiter ?? '-' }}{{ str_pad(panierSetting()->start ?? 1, panierSetting()->digit ?? 4, '0', panierSetting()->pad_type ?? 0) }}{{ panierSetting()->suffix }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Transactions Number Generation -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-purple-100 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Numéros de Transactions
                    </h2>
                    <p class="text-sm text-slate-600 mt-1">Format: <code
                            class="px-2 py-0.5 bg-white rounded text-purple-600 font-mono">{{ transactionSetting()->prefix }}{{ transactionSetting()->delimiter }}0001{{ transactionSetting()->suffix }}</code>
                    </p>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-admin.setting-field name="transaction_generator_type" label="Type de Génération"
                                type="select" :value="transactionSetting()->generator_type" required :options="[
                                    'by_order' => 'Séquentiel',
                                    'by_random' => 'Aléatoire',
                                ]"
                                help="Méthode de génération" />
                        </div>

                        <div>
                            <x-admin.setting-field name="transaction_prefix" label="Préfixe" type="text"
                                :value="transactionSetting()->prefix" placeholder="TXN" />
                        </div>

                        <div>
                            <x-admin.setting-field name="transaction_suffix" label="Suffixe" type="text"
                                :value="transactionSetting()->suffix" />
                        </div>

                        <div>
                            <x-admin.setting-field name="transaction_delimiter" label="Séparateur" type="text"
                                :value="transactionSetting()->delimiter" placeholder="-" />
                        </div>

                        <div>
                            <x-admin.setting-field name="transaction_start" label="Numéro de Départ" type="number"
                                :value="transactionSetting()->start" placeholder="1" />
                        </div>

                        <div>
                            <x-admin.setting-field name="transaction_digit" label="Nombre de Chiffres" type="number"
                                :value="transactionSetting()->digit" placeholder="4" />
                        </div>

                        <div>
                            <x-admin.setting-field name="transaction_pad_type" label="Type de Remplissage" type="select"
                                :value="transactionSetting()->pad_type" :options="[
                                    '0' => 'Gauche (0001)',
                                    '1' => 'Droite (1000)',
                                    '2' => 'Les Deux (0100)',
                                ]" />
                        </div>
                    </div>

                    <!-- Preview -->
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                        <p class="text-sm font-medium text-purple-900 mb-2">Aperçu du Format</p>
                        <p class="text-lg font-mono text-purple-700">
                            {{ transactionSetting()->prefix ?? 'TXN' }}{{ transactionSetting()->delimiter ?? '-' }}{{ str_pad(transactionSetting()->start ?? 1, transactionSetting()->digit ?? 4, '0', transactionSetting()->pad_type ?? 0) }}{{ transactionSetting()->suffix }}
                        </p>
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

@extends('layouts.admin')

@section('title', 'Paramètres Généraux')
@section('page-title', 'Paramètres Généraux')

@section('content')
    @php
        $faviconUrl = $settings->favicon ? asset('storage/' . ltrim($settings->favicon, '/')) : asset('favicon.svg');
        $appleTouchIconUrl = $settings->app_logo ? asset('storage/' . ltrim($settings->app_logo, '/')) : asset('savemelogo.png');
    @endphp

    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Paramètres Généraux</h1>
                <p class="mt-1 text-sm text-slate-600">Configuration de base de votre application</p>
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
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Informations Générales
                </h2>
            </div>

            <form action="{{ route('admin.settings.general.update') }}" method="POST" enctype="multipart/form-data"
                class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Site Information -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Informations d'application
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <x-admin.setting-field name="app_name" label="Nom d'app" type="text" :value="$settings->app_name"
                                    placeholder="SAVEME" required help="Le nom de votre application affiché partout" />
                            </div>

                            <div class="md:col-span-2">
                                <x-admin.setting-field name="app_description" label="Description d'app" type="textarea"
                                    :value="$settings->app_description" placeholder="Description courte de votre app..." rows="3"
                                    help="Une brève description de votre application" />
                            </div>

                            <div>
                                <x-admin.setting-field name="app_logo" label="Logo" type="file" :value="$settings->app_logo"
                                    help="Format recommandé: PNG avec fond transparent, 200x50px" />
                            </div>

                            <div>
                                <x-admin.setting-field name="favicon" label="Favicon" type="file" :value="$settings->favicon"
                                    help="Format: ICO ou PNG, 32x32px ou 64x64px" />
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Aperçu Favicon</p>
                                <div class="mt-4 flex items-center gap-4">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm">
                                        <img src="{{ $faviconUrl }}" alt="Favicon actuel" class="h-10 w-10 object-contain">
                                    </div>
                                    <div class="space-y-1 text-sm text-slate-600">
                                        <p class="font-medium text-slate-900">Icône d’onglet actuelle</p>
                                        <p>Utilisée dans les navigateurs et favoris.</p>
                                        <p class="text-xs text-slate-500 break-all">{{ $faviconUrl }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Icône Mobile</p>
                                <div class="mt-4 flex items-center gap-4">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-[1.25rem] border border-slate-200 bg-white shadow-sm">
                                        <img src="{{ $appleTouchIconUrl }}" alt="Icône mobile" class="h-11 w-11 object-contain">
                                    </div>
                                    <div class="space-y-1 text-sm text-slate-600">
                                        <p class="font-medium text-slate-900">Apple touch icon</p>
                                        <p>Prend le logo de l’application si aucun favicon n’est dédié.</p>
                                        <p class="text-xs text-slate-500 break-all">{{ $appleTouchIconUrl }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="pt-6 border-t border-slate-200">
                        <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Coordonnées de Contact
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-admin.setting-field name="contact_email" label="Email de Contact" type="email"
                                    :value="$settings->contact_email" placeholder="contact@example.com" required
                                    help="Adresse email principale de contact" />
                            </div>

                            <div>
                                <x-admin.setting-field name="contact_phone" label="Téléphone de Contact" type="text"
                                    :value="$settings->contact_phone" placeholder="+212 6XX XXX XXX" help="Numéro de téléphone principal" />
                            </div>

                            <div class="md:col-span-2">
                                <x-admin.setting-field name="address" label="Adresse" type="textarea" :value="$settings->address"
                                    placeholder="Adresse complète de votre entreprise..." rows="3"
                                    help="Adresse postale complète" />
                            </div>
                        </div>
                    </div>

                    <!-- Regional Settings -->
                    <div class="pt-6 border-t border-slate-200">
                        <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Paramètres Régionaux
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div>
                                <x-admin.setting-field name="timezone" label="Fuseau Horaire" type="select"
                                    :value="$settings->timezone" required :options="[
                                        'Africa/Casablanca' => 'Africa/Casablanca (GMT+1)',
                                        'Europe/Paris' => 'Europe/Paris (GMT+2)',
                                        'UTC' => 'UTC',
                                    ]" help="Fuseau horaire de l'application" />
                            </div>

                            <div>
                                <x-admin.setting-field name="language" label="Langue" type="select" :value="$settings->language"
                                    required :options="[
                                        'fr' => 'Français',
                                        'en' => 'English',
                                    ]" help="Langue de l'interface" />
                            </div>

                            <div>
                                <x-admin.setting-field name="date_format" label="Format de Date" type="select"
                                    :value="$settings->date_format" required :options="[
                                        'd/m/Y' => 'JJ/MM/AAAA',
                                        'm/d/Y' => 'MM/JJ/AAAA',
                                        'Y-m-d' => 'AAAA-MM-JJ',
                                    ]" help="Format d'affichage des dates" />
                            </div>

                            <div>
                                <x-admin.setting-field name="currency" label="Devise" type="select" :value="$settings->currency"
                                    required :options="[
                                        'MAD' => 'MAD (Dirham Marocain)',
                                        'EUR' => 'EUR (Euro)',
                                        'USD' => 'USD (Dollar US)',
                                    ]" help="Devise principale" />
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

@extends('layouts.admin')

@section('title', 'Mon Profil')
@section('page-title', 'Mon Profil')

@section('content')
    <div class="max-w-5xl mx-auto">
        <!-- Header with Avatar -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-sm p-8 mb-6">
            <div class="flex items-center gap-6">
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 rounded-full bg-white/20 backdrop-blur-sm border-4 border-white/30 flex items-center justify-center text-white text-3xl font-bold">
                        {{ substr($user->full_name, 0, 2) }}
                    </div>
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-white">{{ $user->full_name }}</h1>
                    <p class="text-blue-100 mt-1">{{ $user->email }}</p>
                    <div class="flex items-center gap-4 mt-3">
                        @if ($user->email_verified_at)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Email Vérifié
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                Email Non Vérifié
                            </span>
                        @endif
                        <span class="text-blue-100 text-sm">
                            Membre depuis {{ $user->created_at->locale('fr')->isoFormat('MMMM YYYY') }}
                        </span>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <x-admin.button href="{{ route('admin.profile.edit') }}" variant="outline" class="bg-white/10 border-white/30 text-white hover:bg-white/20">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Modifier le Profil
                    </x-admin.button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Personal Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Information -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Informations Personnelles
                        </h2>
                    </div>

                    <div class="p-6">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Prénom
                                </dt>
                                <dd class="text-sm text-slate-900 font-semibold">{{ $user->prenom ?? 'Non renseigné' }}</dd>
                            </div>

                            <div>
                                <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Nom
                                </dt>
                                <dd class="text-sm text-slate-900 font-semibold">{{ $user->nom ?? 'Non renseigné' }}</dd>
                            </div>

                            <div>
                                <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    E-mail
                                </dt>
                                <dd class="text-sm text-slate-900 font-semibold">{{ $user->email }}</dd>
                            </div>

                            @if($user->telephone)
                                <div>
                                    <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        Téléphone
                                    </dt>
                                    <dd class="text-sm text-slate-900 font-semibold">{{ $user->telephone }}</dd>
                                </div>
                            @endif

                            @if($user->date_of_birth)
                                <div>
                                    <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Date de Naissance
                                    </dt>
                                    <dd class="text-sm text-slate-900 font-semibold">{{ $user->date_of_birth->format('d/m/Y') }}</dd>
                                </div>
                            @endif

                            @if($user->address)
                                <div class="md:col-span-2">
                                    <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Adresse
                                    </dt>
                                    <dd class="text-sm text-slate-900 font-semibold">{{ $user->address }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Informations du Compte
                        </h2>
                    </div>

                    <div class="p-6">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Statut E-mail
                                </dt>
                                <dd class="text-sm">
                                    @if ($user->email_verified_at)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Vérifié le {{ $user->email_verified_at->format('d/m/Y') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                            Non Vérifié
                                        </span>
                                    @endif
                                </dd>
                            </div>

                            <div>
                                <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Membre Depuis
                                </dt>
                                <dd class="text-sm text-slate-900 font-semibold">
                                    {{ $user->created_at->locale('fr')->isoFormat('D MMMM YYYY') }}
                                    <span class="text-slate-500">({{ $user->created_at->diffForHumans() }})</span>
                                </dd>
                            </div>

                            <div>
                                <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Dernière Modification
                                </dt>
                                <dd class="text-sm text-slate-900 font-semibold">{{ $user->updated_at->format('d/m/Y à H:i') }}</dd>
                            </div>

                            <div>
                                <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                    </svg>
                                    ID Utilisateur
                                </dt>
                                <dd class="text-sm text-slate-900 font-mono">#{{ $user->id }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Right Column - Quick Actions -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900">Actions Rapides</h2>
                    </div>

                    <div class="p-6 space-y-3">
                        <a href="{{ route('admin.profile.edit') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-50 transition group border border-slate-200">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-200 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-slate-900">Modifier le Profil</p>
                                <p class="text-xs text-slate-600">Mettre à jour vos informations</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.profile.password') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-50 transition group border border-slate-200">
                            <div class="w-10 h-10 rounded-lg bg-green-100 text-green-600 flex items-center justify-center group-hover:bg-green-200 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-slate-900">Changer le Mot de Passe</p>
                                <p class="text-xs text-slate-600">Sécuriser votre compte</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.profile.settings') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-50 transition group border border-slate-200">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center group-hover:bg-purple-200 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-slate-900">Paramètres</p>
                                <p class="text-xs text-slate-600">Préférences du compte</p>
                            </div>
                        </a>

                        @role('PROFESSIONAL')
                            <a href="{{ route('admin.profile.business-info') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-50 transition group border border-slate-200">
                                <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center group-hover:bg-amber-200 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10l9-7 9 7M4 10h16v10H4V10zm4 4h2m4 0h2" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-slate-900">Informations de l’entreprise</p>
                                    <p class="text-xs text-slate-600">Consulter vos coordonnées administratives</p>
                                </div>
                            </a>
                        @endrole
                    </div>
                </div>

                <!-- Security -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900">Sécurité</h2>
                    </div>

                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-3 border-b border-slate-200">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-medium text-slate-900">Authentification</span>
                                </div>
                                <span class="text-xs text-slate-600">Active</span>
                            </div>

                            <div class="flex items-center justify-between py-3 border-b border-slate-200">
                                <div class="flex items-center gap-2">
                                    @if($user->email_verified_at)
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                    <span class="text-sm font-medium text-slate-900">Vérification E-mail</span>
                                </div>
                                <span class="text-xs text-slate-600">{{ $user->email_verified_at ? 'Vérifié' : 'Non vérifié' }}</span>
                            </div>

                            <div class="flex items-center justify-between py-3">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-medium text-slate-900">Dernier accès</span>
                                </div>
                                <span class="text-xs text-slate-600">{{ now()->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

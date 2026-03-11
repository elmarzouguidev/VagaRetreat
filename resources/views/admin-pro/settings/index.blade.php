@extends('layouts.admin')

@section('title', 'Paramètres')
@section('page-title', 'Paramètres de l\'Application')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Paramètres</h1>
                <p class="mt-1 text-sm text-slate-600">Configurez les paramètres globaux de votre application</p>
            </div>
        </div>



        <!-- Settings Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- General Settings Card -->
            @can('view-settings')
                <a href="{{ route('admin.settings.general') }}"
                    class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-blue-300 transition group">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex-shrink-0 p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg group-hover:scale-110 transition">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-900 mb-1 group-hover:text-blue-600 transition">
                                Paramètres Généraux
                            </h3>
                            <p class="text-sm text-slate-600">
                                Nom du site, logo, coordonnées, fuseau horaire et devise
                            </p>
                        </div>
                    </div>
                </a>
            @endcan
            <!-- App Settings Card -->
            @can('view-settings')
                <a href="{{ route('admin.settings.app') }}"
                    class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-teal-300 transition group">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex-shrink-0 p-3 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg group-hover:scale-110 transition">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-900 mb-1 group-hover:text-teal-600 transition">
                                Paramètres Application
                            </h3>
                            <p class="text-sm text-slate-600">
                                Pagination, uploads, sessions et comportement de l'app
                            </p>
                        </div>
                    </div>
                </a>
            @endcan

            <!-- Email Settings Card -->
            @can('view-settings')
                <a href="{{ route('admin.settings.email') }}"
                    class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-green-300 transition group">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex-shrink-0 p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-lg group-hover:scale-110 transition">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-900 mb-1 group-hover:text-green-600 transition">
                                Paramètres Email
                            </h3>
                            <p class="text-sm text-slate-600">
                                Configuration SMTP, adresse d'expédition et serveur mail
                            </p>
                        </div>
                    </div>
                </a>
            @endcan

            <!-- Payment Settings Card -->
            @can('view-settings')
                <a href="{{ route('admin.settings.payment') }}"
                    class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-purple-300 transition group">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex-shrink-0 p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg group-hover:scale-110 transition">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-900 mb-1 group-hover:text-purple-600 transition">
                                Paramètres de Paiement
                            </h3>
                            <p class="text-sm text-slate-600">
                                Clés Stripe, webhook et configuration des paiements
                            </p>
                        </div>
                    </div>
                </a>
            @endcan

            <!-- Number Generation Settings Card -->
            @can('view-settings')
                <a href="{{ route('admin.settings.number-generation') }}"
                    class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-cyan-300 transition group">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex-shrink-0 p-3 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg group-hover:scale-110 transition">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-900 mb-1 group-hover:text-cyan-600 transition">
                                Paramètres de Numéros
                            </h3>
                            <p class="text-sm text-slate-600">
                                Configuration des numéros de commandes, paniers et transactions
                            </p>
                        </div>
                    </div>
                </a>
            @endcan
            <!-- Notification Settings Card -->
            @can('view-settings')
                <a href="{{ route('admin.settings.notifications') }}"
                    class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-yellow-300 transition group">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex-shrink-0 p-3 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg group-hover:scale-110 transition">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-900 mb-1 group-hover:text-yellow-600 transition">
                                Notifications
                            </h3>
                            <p class="text-sm text-slate-600">
                                Emails, SMS et alertes pour les commandes et événements
                            </p>
                        </div>
                    </div>
                </a>
            @endcan
            <!-- Backup Settings Card -->
            @can('view-settings')
                <a href="{{ route('admin.settings.backup') }}"
                    class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-emerald-300 transition group">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex-shrink-0 p-3 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg group-hover:scale-110 transition">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-900 mb-1 group-hover:text-emerald-600 transition">
                                Sauvegarde & Logs
                            </h3>
                            <p class="text-sm text-slate-600">
                                Sauvegardes automatiques et gestion des logs
                            </p>
                        </div>
                    </div>
                </a>
            @endcan
            <!-- Social Media Settings Card -->
            @can('view-settings')
                <a href="{{ route('admin.settings.social') }}"
                    class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-pink-300 transition group">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex-shrink-0 p-3 bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg group-hover:scale-110 transition">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-900 mb-1 group-hover:text-pink-600 transition">
                                Réseaux Sociaux
                            </h3>
                            <p class="text-sm text-slate-600">
                                Liens vers vos profils Facebook, Instagram, Twitter
                            </p>
                        </div>
                    </div>
                </a>
            @endcan
            <!-- Maintenance Settings Card -->
            @can('view-settings')
                <a href="{{ route('admin.settings.maintenance') }}"
                    class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-orange-300 transition group">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex-shrink-0 p-3 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg group-hover:scale-110 transition">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-900 mb-1 group-hover:text-orange-600 transition">
                                Mode Maintenance
                            </h3>
                            <p class="text-sm text-slate-600">
                                Activer le mode maintenance et configurer le message
                            </p>
                        </div>
                    </div>
                </a>
            @endcan


        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-blue-900 mb-1">À propos des paramètres</h3>
                    <p class="text-sm text-blue-800">
                        Les paramètres sont mis en cache pour améliorer les performances.
                        Si vous ne voyez pas vos modifications immédiatement, essayez de vider le cache de l'application.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

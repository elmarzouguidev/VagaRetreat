@extends('layouts.admin')

@section('title', 'Détails de l\'Utilisateur')
@section('page-title', 'Détails de l\'Utilisateur')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <x-admin.button href="{{ route('admin.users.index') }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour aux Utilisateurs
            </x-admin.button>

            <div class="flex gap-2">
                @can('assign-roles')
                    <x-admin.button href="{{ route('admin.users.roles.edit', $user) }}" variant="outline">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Gérer les Rôles
                    </x-admin.button>
                @endcan

                @can('edit-users')
                    <x-admin.button href="{{ route('admin.users.edit', $user) }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier
                    </x-admin.button>
                @endcan
            </div>
        </div>

        <!-- User Header Card -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-sm p-8 mb-6">
            <div class="flex items-center gap-6">
                <div
                    class="w-24 h-24 rounded-full bg-white/20 backdrop-blur-sm border-4 border-white/30 flex items-center justify-center text-white text-3xl font-bold">
                    {{ substr($user->full_name, 0, 2) }}
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-white">{{ $user->full_name }}</h1>
                    <p class="text-blue-100 mt-1 text-lg">{{ $user->email }}</p>
                    <div class="flex items-center gap-4 mt-3">
                        @if ($user->email_verified_at)
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                Email Vérifié
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                Email Non Vérifié
                            </span>
                        @endif
                        <span class="text-blue-100 text-sm">
                            Membre depuis {{ $user->created_at->locale('fr')->isoFormat('MMMM YYYY') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - User Info -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Personal Info -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Informations Personnelles
                    </h2>

                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Nom Complet</dt>
                            <dd class="text-sm text-slate-900 font-semibold">{{ $user->full_name }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Prénom</dt>
                            <dd class="text-sm text-slate-900">{{ $user->prenom ?? 'Non renseigné' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Nom</dt>
                            <dd class="text-sm text-slate-900">{{ $user->nom ?? 'Non renseigné' }}</dd>
                        </div>

                        @if ($user->telephone)
                            <div>
                                <dt class="text-sm font-medium text-slate-700 mb-1">Téléphone</dt>
                                <dd class="text-sm text-slate-900">{{ $user->telephone }}</dd>
                            </div>
                        @endif

                        @if ($user->date_of_birth)
                            <div>
                                <dt class="text-sm font-medium text-slate-700 mb-1">Date de Naissance</dt>
                                <dd class="text-sm text-slate-900">{{ $user->date_of_birth->format('d/m/Y') }}</dd>
                            </div>
                        @endif

                        @if ($user->gender)
                            <div>
                                <dt class="text-sm font-medium text-slate-700 mb-1">Genre</dt>
                                <dd class="text-sm text-slate-900">
                                    {{ $user->gender === 'male' ? 'Homme' : ($user->gender === 'female' ? 'Femme' : 'Autre') }}
                                </dd>
                            </div>
                        @endif

                        @if ($user->address)
                            <div>
                                <dt class="text-sm font-medium text-slate-700 mb-1">Adresse</dt>
                                <dd class="text-sm text-slate-900">{{ $user->address }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Account Info -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Informations du Compte
                    </h2>

                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">ID Utilisateur</dt>
                            <dd class="text-sm text-slate-900 font-mono">#{{ $user->id }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Email</dt>
                            <dd class="text-sm text-slate-900">{{ $user->email }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Statut Email</dt>
                            <dd>
                                @if ($user->email_verified_at)
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Vérifié le {{ $user->email_verified_at->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Non Vérifié
                                    </span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Créé le</dt>
                            <dd class="text-sm text-slate-900">
                                {{ $user->created_at->format('d/m/Y à H:i') }}
                                <span class="text-slate-500">({{ $user->created_at->diffForHumans() }})</span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Dernière Modification</dt>
                            <dd class="text-sm text-slate-900">{{ $user->updated_at->format('d/m/Y à H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Right Column - Roles & Activity -->
            <div class="lg:col-span-2 space-y-6">
                @if (auth()->user()?->hasRole(\App\Enums\Roles\RolesEnums::SUPERADMIN->value) &&
                        $user->hasRole(\App\Enums\Roles\RolesEnums::PROFESSIONAL->value))
                    @include('admin.users.partials.business-info', ['user' => $user])
                @endif

                <!-- Roles & Permissions -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Rôles & Permissions
                        </h2>
                    </div>

                    <div class="p-6">
                        @if ($user->roles->count() > 0)
                            <div class="space-y-4">
                                @foreach ($user->roles as $role)
                                    <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div
                                                class="w-12 h-12 rounded-lg {{ $role->name === 'super-admin' ? 'bg-purple-100 text-purple-600' : ($role->name === 'admin' ? 'bg-blue-100 text-blue-600' : ($role->name === 'manager' ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-600')) }} flex items-center justify-center">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-sm font-semibold text-slate-900">
                                                    {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                                </h3>
                                                <p class="text-xs text-slate-600">{{ $role->permissions->count() }}
                                                    permissions</p>
                                            </div>
                                        </div>

                                        @if ($role->permissions->count() > 0)
                                            <div>
                                                <p class="text-xs font-medium text-slate-700 mb-2">Permissions:</p>
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach ($role->permissions->take(10) as $permission)
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                            {{ $permission->name }}
                                                        </span>
                                                    @endforeach
                                                    @if ($role->permissions->count() > 10)
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-200 text-slate-600">
                                                            +{{ $role->permissions->count() - 10 }} autres
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p class="text-slate-500 text-sm">Aucun rôle assigné</p>
                                @can('assign-roles')
                                    <a href="{{ route('admin.users.roles.edit', $user) }}"
                                        class="inline-block mt-2 text-sm text-blue-600 hover:text-blue-800">
                                        Assigner des rôles
                                    </a>
                                @endcan
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Activity -->
                @if ($activities->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Activité Récente
                            </h2>
                        </div>

                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach ($activities as $activity)
                                    <div class="flex gap-3 pb-4 border-b border-slate-200 last:border-0 last:pb-0">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-8 h-8 rounded-full {{ $activity->color }} flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="{{ $activity->icon }}" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-slate-900">{{ $activity->description }}</p>
                                            <p class="text-xs text-slate-500 mt-1">
                                                {{ $activity->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @can('view-activity-logs')
                                <div class="mt-4 pt-4 border-t border-slate-200">
                                    <a href="{{ route('admin.activity-logs.index', ['user_id' => $user->id]) }}"
                                        class="text-sm text-blue-600 hover:text-blue-800">
                                        Voir toute l'activité →
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>
                @endif

                <!-- Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-600">Rôles</p>
                                <p class="text-2xl font-bold text-slate-900">{{ $user->roles->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 p-3 bg-green-100 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-600">Permissions</p>
                                <p class="text-2xl font-bold text-slate-900">{{ $user->getAllPermissions()->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 p-3 bg-purple-100 rounded-lg">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-600">Activités</p>
                                <p class="text-2xl font-bold text-slate-900">{{ $activities->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

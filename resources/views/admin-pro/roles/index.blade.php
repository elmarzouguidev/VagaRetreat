@extends('layouts.admin')

@section('title', 'Rôles & Permissions')
@section('page-title', 'Gestion des Rôles')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Rôles & Permissions</h1>
                <p class="mt-1 text-sm text-slate-600">Gérez les rôles et les permissions des utilisateurs</p>
            </div>
            <div class="flex gap-2">
                @can('view-permissions')
                    <x-admin.button href="{{ route('admin.permissions.matrix') }}" variant="outline">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                        </svg>
                        Matrice des Permissions
                    </x-admin.button>
                @endcan
                @can('create-roles')
                    <x-admin.button href="{{ route('admin.roles.create') }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Créer un Rôle
                    </x-admin.button>
                @endcan
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-600">Total Rôles</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $roles->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-600">Permissions</p>
                        <p class="text-2xl font-bold text-slate-900">{{ \App\Models\Permission::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-600">Utilisateurs</p>
                        <p class="text-2xl font-bold text-slate-900">{{ \App\Models\User::count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Roles List -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($roles as $role)
                <div
                    class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition">
                    <div class="p-6">
                        <!-- Role Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-12 h-12 rounded-lg {{ $role->name === \App\Enums\Roles\RolesEnums::SUPERADMIN->value ? 'bg-gradient-to-br from-purple-500 to-purple-600' : ($role->name === \App\Enums\Roles\RolesEnums::SUPERADMIN->value ? 'bg-gradient-to-br from-blue-500 to-blue-600' : ($role->name === \App\Enums\Roles\RolesEnums::MANAGER->value ? 'bg-gradient-to-br from-green-500 to-green-600' : 'bg-gradient-to-br from-slate-500 to-slate-600')) }} flex items-center justify-center text-white">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-900">
                                        {{ $role->label }}
                                    </h3>

                                    @if ($role->name === \App\Enums\Roles\RolesEnums::SUPERADMIN->value)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 mt-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Système
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="bg-slate-50 rounded-lg p-3 border border-slate-200">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-xs text-slate-600">Utilisateurs</p>
                                        <p class="text-lg font-bold text-slate-900">{{ $role->users_count }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-slate-50 rounded-lg p-3 border border-slate-200">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <div>
                                        <p class="text-xs text-slate-600">Permissions</p>
                                        <p class="text-lg font-bold text-slate-900">{{ $role->permissions?->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Permissions Preview -->
                        @if ($role->permissions->count() > 0)
                            <div class="mb-4">
                                <p class="text-xs font-medium text-slate-700 mb-2">Permissions clés :</p>
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($role->permissions->take(3) as $permission)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $permission->label }}
                                        </span>
                                    @endforeach
                                    @if ($role->permissions->count() > 3)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-600">
                                            +{{ $role->permissions->count() - 3 }} autres
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="flex gap-2 pt-4 border-t border-slate-200">
                            @can('view-roles')
                                <a href="{{ route('admin.roles.show', $role) }}"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Voir
                                </a>
                            @endcan

                            @can('edit-roles')
                                @if ($role->name !== \App\Enums\Roles\RolesEnums::SUPERADMIN->value)
                                    <a href="{{ route('admin.roles.edit', $role) }}"
                                        class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Modifier
                                    </a>
                                @else
                                    <div
                                        class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-slate-100 text-slate-400 rounded-lg text-sm font-medium cursor-not-allowed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        Protégé
                                    </div>
                                @endif
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

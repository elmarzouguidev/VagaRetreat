@extends('layouts.admin')

@section('title', 'Permissions')
@section('page-title', 'Gestion des Permissions')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Permissions</h1>
                <p class="mt-1 text-sm text-slate-600">Liste de toutes les permissions disponibles dans le système</p>
            </div>
            <div class="flex gap-2">
                <x-admin.button href="{{ route('admin.permissions.matrix') }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                    </svg>
                    Vue Matrice
                </x-admin.button>
                <x-admin.button href="{{ route('admin.roles.index') }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour aux Rôles
                </x-admin.button>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-600">Total Permissions</p>
                        <p class="text-2xl font-bold text-slate-900">{{ \App\Models\Permission::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-600">Catégories</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $permissions->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-600">Rôles</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $roles->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

        <!-- Permissions by Category -->
        <div class="space-y-4">
            @foreach ($permissions as $group => $groupPermissions)
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                {{ __("permissions.groups.$group") !== "permissions.groups.$group" ? __("permissions.groups.$group") : ucfirst($group) }}
                            </h3>
                            <span class="text-sm text-slate-600">{{ $groupPermissions->count() }} permissions</span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach ($groupPermissions as $permission)
                                <div
                                    class="bg-slate-50 rounded-lg p-4 border border-slate-200 hover:border-blue-300 transition">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-slate-900">{{ $permission->label }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Roles with this permission -->
                                    <div>
                                        <p class="text-xs font-medium text-slate-700 mb-2">Rôles assignés:</p>
                                        <div class="flex flex-wrap gap-1">
                                            @php
                                                $rolesWithPermission = $roles->filter(
                                                    fn($role) => $role->hasPermissionTo($permission->name),
                                                );
                                            @endphp

                                            @if ($rolesWithPermission->count() > 0)
                                                @foreach ($rolesWithPermission as $role)
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $role->name === 'super-admin' ? 'bg-purple-100 text-purple-800' : ($role->name === 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-800') }}">
                                                        {{ $role->label }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-xs text-slate-500 italic">Aucun rôle</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

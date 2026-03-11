@extends('layouts.admin')

@section('title', 'Détails du Rôle')
@section('page-title', 'Détails du Rôle')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <x-admin.button href="{{ route('admin.roles.index') }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour aux Rôles
            </x-admin.button>

            @can('edit-roles')
                @if ($role->name !== \App\Enums\Roles\RolesEnums::SUPERADMIN->value)
                    <x-admin.button href="{{ route('admin.roles.edit', $role) }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier
                    </x-admin.button>
                @endif
            @endcan
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Role Info -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Role Card -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="w-16 h-16 rounded-lg {{ $role->name === \App\Enums\Roles\RolesEnums::SUPERADMIN->value ? 'bg-gradient-to-br from-purple-500 to-purple-600' : ($role->name === \App\Enums\Roles\RolesEnums::MANAGER->value ? 'bg-gradient-to-br from-green-500 to-green-600' : 'bg-gradient-to-br from-slate-500 to-slate-600') }} flex items-center justify-center text-white">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">
                                {{ $role->label }}
                            </h2>
                            @if ($role->name === \App\Enums\Roles\RolesEnums::SUPERADMIN->value)
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 mt-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Rôle Système
                                </span>
                            @endif
                        </div>
                    </div>

                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Nom Technique</dt>
                            <dd
                                class="text-sm text-slate-900 font-mono bg-slate-50 px-3 py-2 rounded border border-slate-200">
                                {{ $role->name }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Utilisateurs Assignés</dt>
                            <dd class="text-3xl font-bold text-blue-600">{{ $role->users->count() }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Permissions</dt>
                            <dd class="text-3xl font-bold text-green-600">{{ $role->permissions->count() }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Créé le</dt>
                            <dd class="text-sm text-slate-900">{{ $role->created_at->format('d/m/Y à H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Right Column - Permissions & Users -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Permissions -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Permissions ({{ $role->permissions->count() }})
                        </h3>
                    </div>

                    <div class="p-6">
                        @php
                            $groupedPermissions = $role->permissions->groupBy(function ($permission) {
                                return explode('-', $permission->name)[1] ?? 'other';
                            });
                        @endphp

                        @if ($groupedPermissions->count() > 0)
                            <div class="space-y-4">
                                @foreach ($groupedPermissions as $group => $permissions)
                                    <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                                        <h4 class="text-sm font-semibold text-slate-900 mb-3">
                                            {{ __("permissions.groups.$group") !== "permissions.groups.$group" ? __("permissions.groups.$group") : ucfirst($group) }}
                                            <span
                                                class="text-xs font-normal text-slate-600">({{ $permissions->count() }})</span>
                                        </h4>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($permissions as $permission)
                                                <span
                                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    {{ $permission->label }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <p class="text-slate-500 text-sm">Aucune permission assignée</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Users -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Utilisateurs ({{ $role->users->count() }})
                        </h3>
                    </div>

                    <div class="p-6">
                        @if ($role->users->count() > 0)
                            <div class="space-y-3">
                                @foreach ($role->users->take(10) as $user)
                                    <div
                                        class="flex items-center justify-between p-3 bg-slate-50 rounded-lg border border-slate-200">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                                {{ substr($user->full_name, 0, 2) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-slate-900">{{ $user->full_name }}</p>
                                                <p class="text-xs text-slate-600">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                        @can('view-users')
                                            <a href="{{ route('admin.users.show', $user) }}"
                                                class="text-sm text-blue-600 hover:text-blue-800">
                                                Voir
                                            </a>
                                        @endcan
                                    </div>
                                @endforeach

                                @if ($role->users->count() > 10)
                                    <p class="text-sm text-slate-600 text-center pt-2">
                                        Et {{ $role->users->count() - 10 }} autres utilisateurs...
                                    </p>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p class="text-slate-500 text-sm">Aucun utilisateur assigné à ce rôle</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

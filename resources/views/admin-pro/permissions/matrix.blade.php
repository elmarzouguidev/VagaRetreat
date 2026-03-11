@extends('layouts.admin')

@section('title', 'Matrice des Permissions')
@section('page-title', 'Matrice des Permissions')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Matrice des Permissions</h1>
                <p class="mt-1 text-sm text-slate-600">Vue d'ensemble des permissions par rôle</p>
            </div>
            <div class="flex gap-2">
                <x-admin.button href="{{ route('admin.permissions.index') }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Vue Liste
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

        <!-- Legend -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-blue-900">Comment lire cette matrice</p>
                    <p class="text-sm text-blue-700 mt-1">
                        Les lignes représentent les permissions, les colonnes représentent les rôles.
                        Une coche (✓) indique que le rôle possède cette permission.
                    </p>
                </div>
            </div>
        </div>

        <!-- Matrix -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50 sticky top-0 z-10">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider sticky left-0 bg-slate-50 border-r border-slate-200 min-w-[250px]">
                                Permissions
                            </th>
                            @foreach ($roles as $role)
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-slate-700 uppercase tracking-wider min-w-[120px]">
                                    <div class="flex flex-col items-center gap-2">
                                        <div
                                            class="w-8 h-8 rounded-full {{ $role->name === 'super-admin' ? 'bg-purple-100 text-purple-600' : ($role->name === 'admin' ? 'bg-blue-100 text-blue-600' : ($role->name === 'manager' ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-600')) }} flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <span class="text-xs">{{ $role->label }}</span>
                                        <span class="text-xs text-slate-500">({{ $role->permissions->count() }})</span>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @foreach ($permissions as $group => $groupPermissions)
                            <!-- Group Header -->
                            <tr class="bg-slate-100">
                                <td colspan="{{ $roles->count() + 1 }}"
                                    class="px-6 py-3 text-sm font-semibold text-slate-900">
                                    {{ __("permissions.groups.$group") !== "permissions.groups.$group" ? __("permissions.groups.$group") : ucfirst($group) }}
                                    <span class="text-xs font-normal text-slate-600 ml-2">({{ $groupPermissions->count() }}
                                        permissions)</span>
                                </td>
                            </tr>

                            <!-- Permissions -->
                            @foreach ($groupPermissions as $permission)
                                <tr class="hover:bg-slate-50 transition">
                                    <td
                                        class="px-6 py-4 text-sm text-slate-900 font-medium sticky left-0 bg-white border-r border-slate-200">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            {{ $permission->label }}
                                        </div>
                                    </td>
                                    @foreach ($roles as $role)
                                        <td class="px-6 py-4 text-center">
                                            @if ($role->hasPermissionTo($permission->name))
                                                <div
                                                    class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-100">
                                                    <svg class="w-4 h-4 text-green-600" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            @else
                                                <div
                                                    class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-100">
                                                    <svg class="w-4 h-4 text-slate-400" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Résumé des Permissions</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($roles as $role)
                    <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                        <div class="flex items-center gap-3 mb-3">
                            <div
                                class="w-10 h-10 rounded-full {{ $role->name === 'super-admin' ? 'bg-purple-100 text-purple-600' : ($role->name === 'admin' ? 'bg-blue-100 text-blue-600' : ($role->name === 'manager' ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-600')) }} flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">
                                    {{ $role->label }}</p>
                                <p class="text-xs text-slate-600">{{ $role->users()->count() }} utilisateurs</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-600">Permissions:</span>
                                <span class="font-bold text-slate-900">{{ $role->permissions->count() }}</span>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full"
                                    style="width: {{ ($role->permissions->count() / \App\Models\Permission::count()) * 100 }}%">
                                </div>
                            </div>
                            <p class="text-xs text-slate-500">
                                {{ round(($role->permissions->count() / \App\Models\Permission::count()) * 100) }}%
                                du total
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

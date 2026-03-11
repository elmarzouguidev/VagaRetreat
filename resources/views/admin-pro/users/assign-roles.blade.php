@extends('layouts.admin')

@section('title', 'Assigner des Rôles')
@section('page-title', 'Assigner des Rôles')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <x-admin.button href="{{ route('admin.users.index') }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour aux Utilisateurs
            </x-admin.button>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <!-- User Info Header -->
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                <div class="flex items-center gap-4">
                    <div
                        class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm border-4 border-white/30 flex items-center justify-center text-2xl font-bold">
                        {{ substr($user->full_name, 0, 2) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">{{ $user->full_name }}</h2>
                        <p class="text-blue-100 mt-1">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.users.roles.update', $user) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Current Roles Info -->
                    @if ($user->roles->count() > 0)
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-blue-900">Rôles actuels</p>
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        @foreach ($user->roles as $role)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Roles Selection -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-4">
                            Sélectionner les Rôles <span class="text-red-500">*</span>
                        </label>

                        <div class="space-y-3">
                            @foreach ($roles as $role)
                                <div
                                    class="border border-slate-200 rounded-lg p-4 hover:border-blue-300 transition {{ $user->hasRole($role->name) ? 'bg-blue-50 border-blue-300' : '' }}">
                                    <label class="flex items-start gap-4 cursor-pointer">
                                        <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                            class="mt-1 w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500"
                                            {{ $user->hasRole($role->name) || in_array($role->name, old('roles', [])) ? 'checked' : '' }}
                                            {{ $role->name === 'super-admin' && !auth()->user()->hasRole('super-admin') ? 'disabled' : '' }}>

                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div
                                                    class="w-10 h-10 rounded-lg {{ $role->name === 'super-admin' ? 'bg-purple-100 text-purple-600' : ($role->name === 'admin' ? 'bg-blue-100 text-blue-600' : ($role->name === 'manager' ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-600')) }} flex items-center justify-center">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-slate-900">
                                                        {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                                    </p>
                                                    @if ($role->name === 'super-admin')
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

                                            <div class="grid grid-cols-2 gap-3 mb-3">
                                                <div class="bg-white rounded p-2 border border-slate-200">
                                                    <p class="text-xs text-slate-600">Permissions</p>
                                                    <p class="text-sm font-bold text-slate-900">
                                                        {{ $role->permissions->count() }}</p>
                                                </div>
                                                <div class="bg-white rounded p-2 border border-slate-200">
                                                    <p class="text-xs text-slate-600">Utilisateurs</p>
                                                    <p class="text-sm font-bold text-slate-900">
                                                        {{ $role->users()->count() }}</p>
                                                </div>
                                            </div>

                                            <!-- Sample Permissions -->
                                            @if ($role->permissions->count() > 0)
                                                <div>
                                                    <p class="text-xs font-medium text-slate-700 mb-1">Permissions clés:</p>
                                                    <div class="flex flex-wrap gap-1">
                                                        @foreach ($role->permissions->take(5) as $permission)
                                                            <span
                                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700">
                                                                {{ $permission->name }}
                                                            </span>
                                                        @endforeach
                                                        @if ($role->permissions->count() > 5)
                                                            <span
                                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-200 text-slate-600">
                                                                +{{ $role->permissions->count() - 5 }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        @error('roles')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Warning -->
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-orange-600 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-1.964-1.333-2.732 0L3.732 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-orange-900">Attention</p>
                                <p class="text-sm text-orange-700 mt-1">
                                    Les rôles déterminent les permissions de l'utilisateur. Assurez-vous de sélectionner les
                                    rôles appropriés.
                                    Un utilisateur peut avoir plusieurs rôles et obtiendra la combinaison de toutes leurs
                                    permissions.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.users.index') }}" variant="outline">
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
                        Mettre à Jour les Rôles
                    </x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'Modifier l\'Utilisateur')
@section('page-title', 'Modifier l\'Utilisateur')

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
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier l'Utilisateur: {{ $user->full_name }}
                </h2>
                <p class="mt-1 text-sm text-slate-600">Modifiez les informations de l'utilisateur</p>
            </div>

            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Personal Information -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Informations Personnelles
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- First Name -->
                            <div>
                                <label for="prenom" class="block text-sm font-medium text-slate-700 mb-2">
                                    Prénom <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="prenom" id="prenom"
                                    value="{{ old('prenom', $user->prenom) }}" required placeholder="Jean"
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('prenom') border-red-500 @enderror">
                                @error('prenom')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label for="nom" class="block text-sm font-medium text-slate-700 mb-2">
                                    Nom <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom', $user->nom) }}"
                                    required placeholder="Dupont"
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('nom') border-red-500 @enderror">
                                @error('nom')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">
                                    Adresse E-mail <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $user->email) }}" required
                                        placeholder="jean.dupont@saveme.ma"
                                        class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 @enderror">
                                </div>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="telephone" class="block text-sm font-medium text-slate-700 mb-2">
                                    Téléphone
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <input type="tel" name="telephone" id="telephone"
                                        value="{{ old('telephone', $user->telephone) }}" placeholder="+212 6XX XXX XXX"
                                        class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('telephone') border-red-500 @enderror">
                                </div>
                                @error('telephone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date of Birth -->
                            <div>

                                <x-admin.date-picker name="date_of_birth" id="date_of_birth" label="Date de Naissance"
                                    :value="old('date_of_birth', $user->date_of_birth?->format('Y-m-d'))" placeholder="Choisir une date" />
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="gender" class="block text-sm font-medium text-slate-700 mb-2">
                                    Genre
                                </label>
                                <select name="gender" id="gender"
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('gender') border-red-500 @enderror">
                                    <option value="">Sélectionner</option>
                                    <option value="male"
                                        {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Homme</option>
                                    <option value="female"
                                        {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Femme</option>

                                </select>
                                @error('gender')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mt-4">
                            <label for="address" class="block text-sm font-medium text-slate-700 mb-2">
                                Adresse
                            </label>
                            <textarea name="address" id="address" rows="3" placeholder="Adresse complète..."
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('address') border-red-500 @enderror">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Security -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Sécurité
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">
                                    Nouveau Mot de Passe
                                </label>
                                <input type="password" name="password" id="password"
                                    placeholder="Laisser vide pour ne pas changer"
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">
                                    Confirmer le Mot de Passe
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    placeholder="Confirmer le nouveau mot de passe"
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                        </div>

                        <!-- Email Verified -->
                        <div class="mt-4">
                            <label
                                class="flex items-center gap-2 p-3 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                                <input type="checkbox" name="email_verified" value="1"
                                    {{ $user->email_verified_at || old('email_verified') ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                                <div>
                                    <span class="text-sm font-medium text-slate-900">Email vérifié</span>
                                    <p class="text-xs text-slate-600">
                                        @if ($user->email_verified_at)
                                            Vérifié le {{ $user->email_verified_at->format('d/m/Y à H:i') }}
                                        @else
                                            Marquer l'email comme vérifié
                                        @endif
                                    </p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Roles -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Rôles
                        </h3>

                        <div class="space-y-2">
                            @foreach ($roles as $role)
                                <label
                                    class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                        class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500"
                                        {{ $user->hasRole($role->name) || in_array($role->name, old('roles', [])) ? 'checked' : '' }}
                                        {{ $role->name === App\Enums\Roles\RolesEnums::SUPERADMIN->value && !auth()->user()->hasRole(App\Enums\Roles\RolesEnums::SUPERADMIN) ? 'disabled' : '' }}>
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-8 h-8 rounded-lg {{ $role->name === App\Enums\Roles\RolesEnums::SUPERADMIN->value ? 'bg-purple-100 text-purple-600' : ($role->name === App\Enums\Roles\RolesEnums::MANAGER->value ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-600') }} flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-slate-900">
                                                {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                            </span>
                                            <p class="text-xs text-slate-600">{{ $role->permissions->count() }}
                                                permissions</p>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        @error('roles')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-between pt-6 mt-6 border-t border-slate-200">
                    {{--<div>
                        @can('delete-users')
                            @if (
                                $user->id !== auth()->id() &&
                                    !(
                                        $user->hasRole(App\Enums\Roles\RolesEnums::SUPERADMIN) &&
                                        User::role(App\Enums\Roles\RolesEnums::SUPERADMIN)->count() <= 1
                                    ))
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-admin.button type="submit" variant="danger">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Supprimer
                                    </x-admin.button>
                                </form>
                            @endif
                        @endcan
                    </div>--}}

                    <div class="flex gap-3">
                        <x-admin.button href="{{ route('admin.users.index') }}" variant="outline">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Annuler
                        </x-admin.button>
                        <x-admin.button type="submit">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Mettre à Jour
                        </x-admin.button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

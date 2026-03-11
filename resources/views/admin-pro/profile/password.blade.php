@extends('layouts.admin')

@section('title', 'Changer le Mot de Passe')
@section('page-title', 'Changer le Mot de Passe')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <x-admin.button href="{{ route('admin.profile.index') }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour au Profil
            </x-admin.button>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Error Messages -->
        <x-messages.errors />

        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                    Changer le Mot de Passe
                </h2>
                <p class="mt-1 text-sm text-slate-600">Mettez à jour le mot de passe de votre compte pour plus de sécurité.
                </p>
            </div>

            <form action="{{ route('admin.profile.password.update') }}" method="POST" class="p-6" id="password-form">
                @csrf
                @method('PUT')
                @honeypot

                <div class="space-y-6">
                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-slate-700 mb-2">
                            Mot de Passe Actuel <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" name="current_password" id="current_password" required
                                placeholder="Entrez votre mot de passe actuel"
                                class="w-full pl-10 pr-12 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('current_password') border-red-500 @enderror">
                            <button type="button" onclick="togglePassword('current_password')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg class="w-5 h-5 text-slate-400 hover:text-slate-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-slate-700 mb-2">
                            Nouveau Mot de Passe <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </div>
                            <input type="password" name="new_password" id="new_password" required
                                placeholder="Entrez un nouveau mot de passe" oninput="checkPasswordStrength(this.value)"
                                class="w-full pl-10 pr-12 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('new_password') border-red-500 @enderror">
                            <button type="button" onclick="togglePassword('new_password')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg class="w-5 h-5 text-slate-400 hover:text-slate-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div class="mt-2" id="password-strength-container" style="display: none;">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="flex-1 h-2 bg-slate-200 rounded-full overflow-hidden">
                                    <div id="password-strength-bar" class="h-full transition-all duration-300"
                                        style="width: 0%;"></div>
                                </div>
                                <span id="password-strength-text" class="text-xs font-medium"></span>
                            </div>
                            <ul class="text-xs text-slate-600 space-y-1" id="password-requirements">
                                <li class="flex items-center gap-2">
                                    <span id="req-length" class="text-slate-400">○</span>
                                    Au moins 8 caractères
                                </li>
                                <li class="flex items-center gap-2">
                                    <span id="req-uppercase" class="text-slate-400">○</span>
                                    Une lettre majuscule
                                </li>
                                <li class="flex items-center gap-2">
                                    <span id="req-lowercase" class="text-slate-400">○</span>
                                    Une lettre minuscule
                                </li>
                                <li class="flex items-center gap-2">
                                    <span id="req-number" class="text-slate-400">○</span>
                                    Un chiffre
                                </li>
                                <li class="flex items-center gap-2">
                                    <span id="req-special" class="text-slate-400">○</span>
                                    Un caractère spécial (!@#$%^&*)
                                </li>
                            </ul>
                        </div>

                        @error('new_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm New Password -->
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">
                            Confirmer le Nouveau Mot de Passe <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                required placeholder="Confirmez votre nouveau mot de passe" oninput="checkPasswordMatch()"
                                class="w-full pl-10 pr-12 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <button type="button" onclick="togglePassword('new_password_confirmation')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg class="w-5 h-5 text-slate-400 hover:text-slate-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        <p id="password-match-message" class="mt-1 text-sm" style="display: none;"></p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.profile.index') }}" variant="outline">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Annuler
                    </x-admin.button>
                    <x-admin.button type="submit">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                        Changer le Mot de Passe
                    </x-admin.button>
                </div>
            </form>
        </div>

        <!-- Security Tips -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Conseils de Sécurité</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Utilisez un mot de passe unique pour chaque compte</li>
                            <li>Combinez des lettres majuscules, minuscules, des chiffres et des symboles</li>
                            <li>Évitez d'utiliser des informations personnelles évidentes</li>
                            <li>Changez votre mot de passe régulièrement</li>
                            <li>Activez l'authentification à deux facteurs pour plus de sécurité</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function togglePassword(fieldId) {
                const field = document.getElementById(fieldId);
                field.type = field.type === 'password' ? 'text' : 'password';
            }

            function checkPasswordStrength(password) {
                const container = document.getElementById('password-strength-container');
                const bar = document.getElementById('password-strength-bar');
                const text = document.getElementById('password-strength-text');

                if (password.length === 0) {
                    container.style.display = 'none';
                    return;
                }

                container.style.display = 'block';

                let strength = 0;
                const requirements = {
                    length: password.length >= 8,
                    uppercase: /[A-Z]/.test(password),
                    lowercase: /[a-z]/.test(password),
                    number: /[0-9]/.test(password),
                    special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
                };

                // Update requirement indicators
                Object.keys(requirements).forEach(req => {
                    const element = document.getElementById(`req-${req}`);
                    if (requirements[req]) {
                        element.textContent = '✓';
                        element.className = 'text-green-600';
                        strength++;
                    } else {
                        element.textContent = '○';
                        element.className = 'text-slate-400';
                    }
                });

                // Update strength bar
                const percentage = (strength / 5) * 100;
                bar.style.width = percentage + '%';

                if (strength <= 2) {
                    bar.className = 'h-full transition-all duration-300 bg-red-500';
                    text.textContent = 'Faible';
                    text.className = 'text-xs font-medium text-red-600';
                } else if (strength <= 3) {
                    bar.className = 'h-full transition-all duration-300 bg-orange-500';
                    text.textContent = 'Moyen';
                    text.className = 'text-xs font-medium text-orange-600';
                } else if (strength <= 4) {
                    bar.className = 'h-full transition-all duration-300 bg-yellow-500';
                    text.textContent = 'Bon';
                    text.className = 'text-xs font-medium text-yellow-600';
                } else {
                    bar.className = 'h-full transition-all duration-300 bg-green-500';
                    text.textContent = 'Excellent';
                    text.className = 'text-xs font-medium text-green-600';
                }
            }

            function checkPasswordMatch() {
                const password = document.getElementById('new_password').value;
                const confirmation = document.getElementById('new_password_confirmation').value;
                const message = document.getElementById('password-match-message');

                if (confirmation.length === 0) {
                    message.style.display = 'none';
                    return;
                }

                message.style.display = 'block';

                if (password === confirmation) {
                    message.textContent = '✓ Les mots de passe correspondent';
                    message.className = 'mt-1 text-sm text-green-600';
                } else {
                    message.textContent = '✗ Les mots de passe ne correspondent pas';
                    message.className = 'mt-1 text-sm text-red-600';
                }
            }
        </script>
    @endpush
@endsection

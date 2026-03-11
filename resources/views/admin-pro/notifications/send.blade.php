@extends('layouts.admin')
@section('title', 'Envoyer une Notification')
@section('page-title', 'Push Notifications')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex justify-end">
            <a href="{{ route('admin.notifications.inbox') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition text-sm font-medium">
                Ouvrir Inbox Notifications
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 gap-6">
            <div class="bg-white rounded-lg border border-slate-200 p-6 text-center">
                <p class="text-3xl font-bold text-blue-600">{{ $totalUsersWithToken }}</p>
                <p class="text-sm text-slate-600 mt-1">Utilisateurs avec notifications</p>
            </div>
            <div class="bg-white rounded-lg border border-slate-200 p-6 text-center">
                <p class="text-3xl font-bold text-slate-900">{{ $totalUsers }}</p>
                <p class="text-sm text-slate-600 mt-1">Utilisateurs total</p>
            </div>
        </div>

        <!-- Send Form -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    Envoyer une Notification Push
                </h2>
            </div>

            <form method="POST" action="{{ route('admin.notifications.send') }}" class="p-6 space-y-5"
                x-data="{ target: 'all' }">
                @csrf

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Titre <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" maxlength="100"
                        placeholder="ex: 🆕 Nouveau panier disponible!"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('title')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Body -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Message <span
                            class="text-red-500">*</span></label>
                    <textarea name="body" rows="3" maxlength="300" placeholder="ex: Votre panier préféré est disponible à -50%!"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Target -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Destinataires</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="target" value="all" x-model="target" class="text-blue-600"
                                checked>
                            <span class="text-sm text-slate-700">Tous les utilisateurs</span>
                            <span
                                class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-medium">{{ $totalUsersWithToken }}</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="target" value="specific" x-model="target" class="text-blue-600">
                            <span class="text-sm text-slate-700">Utilisateur spécifique</span>
                        </label>
                    </div>
                </div>

                <!-- Specific User (shown only when target = specific) -->
                <div x-show="target === 'specific'" x-transition>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Choisir un utilisateur</label>
                    <select name="user_id"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Sélectionner --</option>
                        @foreach (\App\Models\User::whereNotNull('fcm_token')->get() as $user)
                            <option value="{{ $user->uuid }}">{{ $user->full_name }} — {{ $user->email }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Deep Link (optional) -->
                <div class="border-t border-slate-200 pt-5">
                    <p class="text-sm font-medium text-slate-700 mb-3">Lien dans l'app (optionnel)</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Type</label>
                            <select name="data_type"
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                                <option value="">Aucun</option>
                                <option value="panier">Panier</option>
                                <option value="order">Commande</option>
                                <option value="promo">Promotion</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">ID</label>
                            <input type="number" name="data_id" placeholder="ex: 42"
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Preview -->
                <div class="bg-slate-900 rounded-xl p-4">
                    <p class="text-xs text-slate-400 mb-3 uppercase tracking-wider">Aperçu</p>
                    <div class="bg-white rounded-xl p-3 shadow-sm flex items-start gap-3">
                        <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="text-white text-lg">🛍</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-900">Save Me</p>
                            <p class="text-xs font-semibold text-slate-800 mt-0.5"
                                x-text="document.querySelector('[name=title]')?.value || 'Titre de la notification'"></p>
                            <p class="text-xs text-slate-600 mt-0.5 leading-snug"
                                x-text="document.querySelector('[name=body]')?.value || 'Contenu du message...'"></p>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Envoyer la Notification
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

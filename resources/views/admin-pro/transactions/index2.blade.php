@extends('layouts.admin')

@section('title', 'transactions')
@section('page-title', 'transactions')

@section('content')
    <div class="space-y-6">
        <!-- Header with Create Button -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Gestion des transactions</h1>
                <p class="mt-1 text-sm text-slate-600">Gérez tous vos transactions</p>
            </div>
            <div class="flex-shrink-0">
                <x-admin.button href="{{ route('admin.paniers.create') }}" variant="primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouveau Panier
                </x-admin.button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-5 hover:shadow-md transition">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-600 truncate">Total transactions</p>
                        <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['total'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            <!-- successful -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-5 hover:shadow-md transition">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-600 truncate">Réussie</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($stats['successful'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            <!-- failed -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-5 hover:shadow-md transition">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-600 truncate">Échoué</p>
                        <p class="text-2xl font-bold text-orange-600">{{ number_format($stats['failed'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            <!-- in_progress -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-5 hover:shadow-md transition">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-slate-100 rounded-lg">
                        <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-600 truncate">En cours</p>
                        <p class="text-2xl font-bold text-slate-600">{{ number_format($stats['in_progress'] ?? 0) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <form method="GET" action="{{ route('admin.paniers.index') }}"
                class="space-y-4 sm:space-y-0 sm:flex sm:items-end sm:gap-4">

                <!-- Search Input -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-slate-700 mb-2">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Rechercher
                    </label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Rechercher par nom ou numéro de panier..."
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>

                <!-- Status Filter -->
                <div class="sm:w-48">
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Statut
                    </label>
                    <select id="status" name="status"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">Tous les statuts</option>
                        <option value="failed" @selected(request('status') === 'failed')>échoué</option>
                        <option value="in_progress" @selected(request('status') === 'in_progress')>en cours</option>
                        <option value="successful" @selected(request('status') === 'successful')>réussie</option>
                    </select>
                </div>

                <!-- Enseigne Filter -->
                <div class="sm:w-56">
                    <label for="enseigne" class="block text-sm font-medium text-slate-700 mb-2">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Enseigne
                    </label>
                    <select id="enseigne" name="enseigne"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">Toutes les enseignes</option>
                        @foreach ($enseignes ?? [] as $enseigne)
                            <option value="{{ $enseigne->id }}" @selected(request('enseigne') == $enseigne->id)>
                                {{ $enseigne->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <x-admin.button type="submit" variant="primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Rechercher
                    </x-admin.button>

                    @if (request()->hasAny(['search', 'status', 'enseigne']))
                        <x-admin.button href="{{ route('admin.transactions.index') }}" variant="outline">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Réinitialiser
                        </x-admin.button>
                    @endif
                </div>
            </form>
        </div>

        <!-- transactions Table -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Transaction
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Prix
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                    Numéro
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Enseigne
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Date
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Statut
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($transactions ?? [] as $transaction)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <!-- Panier Name & Type -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex-shrink-0 h-12 w-12 bg-slate-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                        </div>

                                        <div class="min-w-0 flex-1">
                                            <a href="{{ route('admin.transactions.show', $transaction) }}"
                                                class="text-sm font-medium text-slate-900 hover:text-blue-600 transition-colors line-clamp-1">
                                                {{ $transaction->transaction_number }}
                                            </a>
                                            @if ($transaction->command)
                                                <p class="text-xs text-slate-500">
                                                    {{ $transaction->command?->command_number }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Price -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-slate-900">
                                        {{ number_format($transaction->price, 2) }} MAD
                                    </span>
                                </td>

                                <!-- Number -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-mono text-slate-700 bg-slate-100 px-2 py-1 rounded">
                                        {{ $transaction->transaction_number }}
                                    </span>
                                </td>

                                <!-- Enseigne -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($transaction->enseigne)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $transaction->enseigne?->name }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-sm">—</span>
                                    @endif
                                </td>

                                <!-- Created Date -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $transaction->created_at?->format('d/m/Y') }}
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction->status?->color() }}">
                                        @if ($transaction->status?->value() === \App\States\Transaction\Successful::$name)
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                        {{ $transaction->status?->label() }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ getStripePaymentIntentDashboardUrl($transaction->transaction_stripe_id) }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">

                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                id="stripe">
                                                <path fill="#646FDE"
                                                    d="M11.319 9.242h1.673v5.805h-1.673zM4.226 13.355c0-2.005-2.547-1.644-2.547-2.403l.001.002c0-.262.218-.364.567-.368a3.7 3.7 0 0 1 1.658.432V9.434a4.4 4.4 0 0 0-1.654-.307C.9 9.127 0 9.839 0 11.029c0 1.864 2.532 1.561 2.532 2.365 0 .31-.266.413-.638.413-.551 0-1.264-.231-1.823-.538v1.516a4.591 4.591 0 0 0 1.819.382c1.384-.001 2.336-.6 2.336-1.812zM11.314 8.732l1.673-.36V7l-1.673.36zM16.468 9.129a1.86 1.86 0 0 0-1.305.527l-.086-.417H13.61V17l1.665-.357.004-1.902c.24.178.596.425 1.178.425 1.193 0 2.28-.879 2.28-3.016.004-1.956-1.098-3.021-2.269-3.021zm-.397 4.641c-.391.001-.622-.143-.784-.318l-.011-2.501c.173-.193.413-.334.795-.334.607 0 1.027.69 1.027 1.569.005.906-.408 1.584-1.027 1.584zm5.521-4.641c-1.583 0-2.547 1.36-2.547 3.074 0 2.027 1.136 2.964 2.757 2.964.795 0 1.391-.182 1.845-.436v-1.266c-.454.231-.975.371-1.635.371-.649 0-1.219-.231-1.294-1.019h3.259c.007-.087.022-.44.022-.602H24c0-1.725-.825-3.086-2.408-3.086zm-.889 2.448c0-.758.462-1.076.878-1.076.409 0 .844.319.844 1.076h-1.722zm-13.251-.902V9.242H6.188l-.004-1.459-1.625.349-.007 5.396c0 .997.743 1.641 1.729 1.641.548 0 .949-.103 1.171-.224v-1.281c-.214.087-1.264.398-1.264-.595v-2.395h1.264zm3.465.114V9.243c-.225-.08-1.001-.227-1.391.496l-.102-.496h-1.44v5.805h1.662v-3.907c.394-.523 1.058-.42 1.271-.352z">
                                                </path>
                                            </svg>

                                            Voir sur stripe
                                        </a>
                                        <a href="{{ route('admin.transactions.show', $transaction) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Voir
                                        </a>

                                        <a href="#"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Modifier
                                        </a>

                                        <form method="POST" action="{{ route('admin.transactions.delete') }}"
                                            class="inline"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce transaction ? Cette action est irréversible.')">
                                            @csrf
                                            @method('DELETE')
                                            @honeypot
                                            <input type="hidden" name="transaction" value="{{ $transaction->uuid }}">
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-slate-900 mb-1">Aucun panier transaction</h3>
                                        <p class="text-sm text-slate-500 mb-6">Commencez par créer votre premier panier
                                            anti-gaspillage.</p>
                                        <x-admin.button href="{{ route('admin.paniers.create') }}" variant="primary">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Créer un Panier
                                        </x-admin.button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if (isset($transactions) && $transactions->hasPages())
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 px-4 py-3">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
@endsection

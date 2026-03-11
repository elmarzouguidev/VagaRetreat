@extends('layouts.admin')

@section('title', 'Détails Transaction')
@section('page-title', $transaction->transaction_number)

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <x-admin.button href="{{ route('admin.transactions.index') }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour aux Transactions
                </x-admin.button>

                <div class="flex gap-2">
                    <a href="{{ getStripePaymentIntentDashboardUrl($transaction->transaction_stripe_id) }}" target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M11.319 9.242h1.673v5.805h-1.673zM4.226 13.355c0-2.005-2.547-1.644-2.547-2.403l.001.002c0-.262.218-.364.567-.368a3.7 3.7 0 0 1 1.658.432V9.434a4.4 4.4 0 0 0-1.654-.307C.9 9.127 0 9.839 0 11.029c0 1.864 2.532 1.561 2.532 2.365 0 .31-.266.413-.638.413-.551 0-1.264-.231-1.823-.538v1.516a4.591 4.591 0 0 0 1.819.382c1.384-.001 2.336-.6 2.336-1.812zM11.314 8.732l1.673-.36V7l-1.673.36zM16.468 9.129a1.86 1.86 0 0 0-1.305.527l-.086-.417H13.61V17l1.665-.357.004-1.902c.24.178.596.425 1.178.425 1.193 0 2.28-.879 2.28-3.016.004-1.956-1.098-3.021-2.269-3.021zm-.397 4.641c-.391.001-.622-.143-.784-.318l-.011-2.501c.173-.193.413-.334.795-.334.607 0 1.027.69 1.027 1.569.005.906-.408 1.584-1.027 1.584zm5.521-4.641c-1.583 0-2.547 1.36-2.547 3.074 0 2.027 1.136 2.964 2.757 2.964.795 0 1.391-.182 1.845-.436v-1.266c-.454.231-.975.371-1.635.371-.649 0-1.219-.231-1.294-1.019h3.259c.007-.087.022-.44.022-.602H24c0-1.725-.825-3.086-2.408-3.086zm-.889 2.448c0-.758.462-1.076.878-1.076.409 0 .844.319.844 1.076h-1.722zm-13.251-.902V9.242H6.188l-.004-1.459-1.625.349-.007 5.396c0 .997.743 1.641 1.729 1.641.548 0 .949-.103 1.171-.224v-1.281c-.214.087-1.264.398-1.264-.595v-2.395h1.264zm3.465.114V9.243c-.225-.08-1.001-.227-1.391.496l-.102-.496h-1.44v5.805h1.662v-3.907c.394-.523 1.058-.42 1.271-.352z" />
                        </svg>
                        Ouvrir dans Stripe
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Overview Card -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-6">
                            <div>
                                <h1 class="text-2xl font-bold text-slate-900">{{ $transaction->transaction_number }}</h1>
                                <p class="text-sm text-slate-600 mt-1 font-mono">{{ $transaction->transaction_stripe_id }}
                                </p>
                            </div>
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium {{ $transaction->status?->color() }}">
                                @if ($transaction->status?->value() === \App\States\Transaction\Successful::$name)
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @elseif($transaction->status?->value() === \App\States\Transaction\Failed::$name)
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                                {{ $transaction->status?->label() }}
                            </span>
                        </div>

                        <!-- Amount Display -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-200 mb-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-blue-600 font-medium mb-1">Montant de la Transaction</p>
                                    <p class="text-4xl font-bold text-blue-900">{{ number_format($transaction->price, 2) }}
                                        <span class="text-2xl">{{ paymentSettings()->payment_currency }}</span></p>
                                </div>
                                <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Transaction Details -->
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Date de Création
                                </dt>
                                <dd class="text-sm text-slate-900 font-semibold">
                                    {{ $transaction->created_at?->format('d/m/Y à H:i:s') }}
                                </dd>
                            </div>

                            <div>
                                <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Dernière Mise à Jour
                                </dt>
                                <dd class="text-sm text-slate-900 font-semibold">
                                    {{ $transaction->updated_at?->format('d/m/Y à H:i:s') }}
                                </dd>
                            </div>

                            @if ($transaction->paymentMethod)
                                <div class="md:col-span-2">
                                    <dt class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        Méthode de Paiement
                                    </dt>
                                    <dd class="text-sm text-slate-900 font-semibold capitalize">
                                        {{ $transaction->paymentMethod?->name }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Command Details -->
                @if ($transaction->command)
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Détails de la Commande
                            </h2>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="font-medium text-slate-900">{{ $transaction->command?->command_number }}</h3>
                                    <p class="text-sm text-slate-600 mt-1">
                                        Commande passée le {{ $transaction->command?->created_at?->format('d/m/Y à H:i') }}
                                    </p>
                                </div>
                                <div>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction->command?->status?->color() }}">
                                        {{ $transaction->command?->status?->label() }}
                                    </span>
                                </div>
                            </div>

                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <dt class="text-sm font-medium text-slate-700 mb-1">Prix Total</dt>
                                    <dd class="text-sm text-slate-900 font-semibold">
                                        {{ number_format($transaction->command?->price, 2) }} {{ paymentSettings()->payment_currency }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-slate-700 mb-1">Quantité</dt>
                                    <dd class="text-sm text-slate-900 font-semibold">
                                        {{ $transaction->command?->quantity }} unité(s)
                                    </dd>
                                </div>

                                @if ($transaction->command?->panier)
                                    <div class="md:col-span-2">
                                        <dt class="text-sm font-medium text-slate-700 mb-2">Panier</dt>
                                        <dd>
                                            <a href="{{ route('admin.paniers.show', $transaction->command?->panier) }}"
                                                class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                                {{ $transaction->command?->panier?->name }}
                                            </a>
                                        </dd>
                                    </div>
                                @endif
                            </dl>

                            <div class="mt-4 pt-4 border-t border-slate-200">
                                <a href="{{ route('admin.orders.show', $transaction->command) }}"
                                    class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800">
                                    Voir la commande complète
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Stripe Information -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M11.319 9.242h1.673v5.805h-1.673zM4.226 13.355c0-2.005-2.547-1.644-2.547-2.403l.001.002c0-.262.218-.364.567-.368a3.7 3.7 0 0 1 1.658.432V9.434a4.4 4.4 0 0 0-1.654-.307C.9 9.127 0 9.839 0 11.029c0 1.864 2.532 1.561 2.532 2.365 0 .31-.266.413-.638.413-.551 0-1.264-.231-1.823-.538v1.516a4.591 4.591 0 0 0 1.819.382c1.384-.001 2.336-.6 2.336-1.812zM11.314 8.732l1.673-.36V7l-1.673.36zM16.468 9.129a1.86 1.86 0 0 0-1.305.527l-.086-.417H13.61V17l1.665-.357.004-1.902c.24.178.596.425 1.178.425 1.193 0 2.28-.879 2.28-3.016.004-1.956-1.098-3.021-2.269-3.021zm-.397 4.641c-.391.001-.622-.143-.784-.318l-.011-2.501c.173-.193.413-.334.795-.334.607 0 1.027.69 1.027 1.569.005.906-.408 1.584-1.027 1.584zm5.521-4.641c-1.583 0-2.547 1.36-2.547 3.074 0 2.027 1.136 2.964 2.757 2.964.795 0 1.391-.182 1.845-.436v-1.266c-.454.231-.975.371-1.635.371-.649 0-1.219-.231-1.294-1.019h3.259c.007-.087.022-.44.022-.602H24c0-1.725-.825-3.086-2.408-3.086zm-.889 2.448c0-.758.462-1.076.878-1.076.409 0 .844.319.844 1.076h-1.722zm-13.251-.902V9.242H6.188l-.004-1.459-1.625.349-.007 5.396c0 .997.743 1.641 1.729 1.641.548 0 .949-.103 1.171-.224v-1.281c-.214.087-1.264.398-1.264-.595v-2.395h1.264zm3.465.114V9.243c-.225-.08-1.001-.227-1.391.496l-.102-.496h-1.44v5.805h1.662v-3.907c.394-.523 1.058-.42 1.271-.352z" />
                            </svg>
                            Informations Stripe
                        </h2>
                    </div>

                    <div class="p-6">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-slate-700 mb-1">Payment Intent ID</dt>
                                <dd
                                    class="text-sm text-slate-900 font-mono bg-slate-50 px-3 py-2 rounded border border-slate-200 break-all">
                                    {{ $transaction->transaction_stripe_id }}
                                </dd>
                            </div>

                            @if ($transaction->stripe_receipt_url)
                                <div>
                                    <dt class="text-sm font-medium text-slate-700 mb-2">Reçu de Paiement</dt>
                                    <dd>
                                        <a href="{{ $transaction->stripe_receipt_url }}" target="_blank"
                                            class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Télécharger le reçu
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    </dd>
                                </div>
                            @endif

                            <div class="pt-4 border-t border-slate-200">
                                <a href="{{ getStripePaymentIntentDashboardUrl($transaction->transaction_stripe_id) }}"
                                    target="_blank"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <path
                                            d="M11.319 9.242h1.673v5.805h-1.673zM4.226 13.355c0-2.005-2.547-1.644-2.547-2.403l.001.002c0-.262.218-.364.567-.368a3.7 3.7 0 0 1 1.658.432V9.434a4.4 4.4 0 0 0-1.654-.307C.9 9.127 0 9.839 0 11.029c0 1.864 2.532 1.561 2.532 2.365 0 .31-.266.413-.638.413-.551 0-1.264-.231-1.823-.538v1.516a4.591 4.591 0 0 0 1.819.382c1.384-.001 2.336-.6 2.336-1.812zM11.314 8.732l1.673-.36V7l-1.673.36zM16.468 9.129a1.86 1.86 0 0 0-1.305.527l-.086-.417H13.61V17l1.665-.357.004-1.902c.24.178.596.425 1.178.425 1.193 0 2.28-.879 2.28-3.016.004-1.956-1.098-3.021-2.269-3.021zm-.397 4.641c-.391.001-.622-.143-.784-.318l-.011-2.501c.173-.193.413-.334.795-.334.607 0 1.027.69 1.027 1.569.005.906-.408 1.584-1.027 1.584zm5.521-4.641c-1.583 0-2.547 1.36-2.547 3.074 0 2.027 1.136 2.964 2.757 2.964.795 0 1.391-.182 1.845-.436v-1.266c-.454.231-.975.371-1.635.371-.649 0-1.219-.231-1.294-1.019h3.259c.007-.087.022-.44.022-.602H24c0-1.725-.825-3.086-2.408-3.086zm-.889 2.448c0-.758.462-1.076.878-1.076.409 0 .844.319.844 1.076h-1.722zm-13.251-.902V9.242H6.188l-.004-1.459-1.625.349-.007 5.396c0 .997.743 1.641 1.729 1.641.548 0 .949-.103 1.171-.224v-1.281c-.214.087-1.264.398-1.264-.595v-2.395h1.264zm3.465.114V9.243c-.225-.08-1.001-.227-1.391.496l-.102-.496h-1.44v5.805h1.662v-3.907c.394-.523 1.058-.42 1.271-.352z" />
                                    </svg>
                                    Voir dans le Dashboard Stripe
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Customer Info -->
                @if ($transaction->command?->user)
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Client
                            </h2>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-lg font-semibold">
                                    {{ substr($transaction->command?->user?->full_name, 0, 2) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-slate-900">{{ $transaction->command?->user?->full_name }}</p>
                                    <p class="text-sm text-slate-600 truncate">{{ $transaction->command?->user?->email }}
                                    </p>
                                </div>
                            </div>

                            @if ($transaction->command?->user?->telephone)
                                <div class="mt-4 pt-4 border-t border-slate-200">
                                    <a href="tel:{{ $transaction->command?->user?->telephone }}"
                                        class="flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ $transaction->command->user->telephone }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Enseigne Info -->
                @if ($transaction->command?->panier?->enseigne)
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Enseigne
                            </h2>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-4">
                                @if ($transaction->command->panier->enseigne->getFirstMediaUrl('enseignes_logos'))
                                    <img src="{{ $transaction->command->panier->enseigne->getFirstMediaUrl('enseignes_logos') }}"
                                        alt="{{ $transaction->command->panier->enseigne->name }}"
                                        class="w-12 h-12 rounded-lg object-cover border border-slate-200">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-slate-900">
                                        {{ $transaction->command?->panier?->enseigne?->name }}</p>
                                    <p class="text-sm text-slate-600">{{ $transaction->command?->panier?->enseigne?->code }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-slate-200">
                                <a href="{{ route('admin.enseignes.show', $transaction->command?->panier?->enseigne) }}"
                                    class="text-sm text-blue-600 hover:text-blue-800 flex items-center justify-center gap-1">
                                    Voir l'enseigne
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- System Info -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900">Informations Système</h2>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">ID</label>
                            <p class="text-sm text-slate-900">#{{ $transaction->id }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">UUID</label>
                            <p class="text-xs text-slate-600 font-mono break-all">{{ $transaction->uuid }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Créé le</label>
                            <p class="text-sm text-slate-900">{{ $transaction->created_at?->format('d/m/Y à H:i:s') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Dernière modification</label>
                            <p class="text-sm text-slate-900">{{ $transaction->updated_at?->format('d/m/Y à H:i:s') }}</p>
                        </div>

                        @if ($transaction->updated_at->gt($transaction->created_at))
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Modifié il y a</label>
                                <p class="text-sm text-slate-900">{{ $transaction->updated_at->diffForHumans() }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'Paramètres de Notification')
@section('page-title', 'Paramètres de Notification')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Paramètres de Notification</h1>
                <p class="mt-1 text-sm text-slate-600">Configurez les notifications et alertes de l'application</p>
            </div>
            <x-admin.button href="{{ route('admin.settings.index') }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour
            </x-admin.button>
        </div>

        <!-- Navigation Tabs -->
        @include('admin.settings.partials.navigation')

        <form action="{{ route('admin.settings.notifications.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Admin Email Notifications -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Notifications Email Admin
                    </h2>
                    <p class="text-sm text-slate-600 mt-1">Recevez des alertes par email pour les événements importants</p>
                </div>

                <div class="p-6 space-y-4">
                    <!-- Admin Email -->
                    <div class="mb-6">
                        <x-admin.setting-field name="admin_notification_email" label="Email de Notification Admin" type="email"
                            :value="$settings->admin_notification_email" placeholder="admin@example.com" required
                            help="Adresse email qui recevra toutes les notifications admin" />
                    </div>

                    <!-- Notification Toggles -->
                    <div class="space-y-3">
                        <!-- New Order -->
                        <label
                            class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Nouvelle Commande</p>
                                    <p class="text-xs text-slate-600">Notification lors d'une nouvelle commande</p>
                                </div>
                            </div>
                            <input type="checkbox" name="notify_on_new_order" value="1"
                                {{ old('notify_on_new_order', $settings->notify_on_new_order) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                        </label>

                        <!-- Order Status Change -->
                        <label
                            class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Changement de Statut</p>
                                    <p class="text-xs text-slate-600">Notification lors d'un changement de statut de
                                        commande</p>
                                </div>
                            </div>
                            <input type="checkbox" name="notify_on_order_status_change" value="1"
                                {{ old('notify_on_order_status_change', $settings->notify_on_order_status_change) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                        </label>

                        <!-- Payment Received -->
                        <label
                            class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Paiement Reçu</p>
                                    <p class="text-xs text-slate-600">Notification lors d'un paiement réussi</p>
                                </div>
                            </div>
                            <input type="checkbox" name="notify_on_payment_received" value="1"
                                {{ old('notify_on_payment_received', $settings->notify_on_payment_received) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                        </label>

                        <!-- Payment Failed -->
                        <label
                            class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Paiement Échoué</p>
                                    <p class="text-xs text-slate-600">Notification lors d'un échec de paiement</p>
                                </div>
                            </div>
                            <input type="checkbox" name="notify_on_payment_failed" value="1"
                                {{ old('notify_on_payment_failed', $settings->notify_on_payment_failed) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                        </label>

                        <!-- New User Registration -->
                        <label
                            class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Nouvel Utilisateur</p>
                                    <p class="text-xs text-slate-600">Notification lors d'une nouvelle inscription</p>
                                </div>
                            </div>
                            <input type="checkbox" name="notify_on_new_user_registration" value="1"
                                {{ old('notify_on_new_user_registration', $settings->notify_on_new_user_registration) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                        </label>

                        <!-- Low Stock -->
                        <label
                            class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Stock Faible</p>
                                    <p class="text-xs text-slate-600">Alerte quand le stock est en dessous du seuil</p>
                                </div>
                            </div>
                            <input type="checkbox" name="notify_on_low_stock" value="1"
                                {{ old('notify_on_low_stock', $settings->notify_on_low_stock) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                        </label>
                    </div>
                </div>
            </div>

            <!-- Periodic Reports -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-purple-100 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Rapports Périodiques
                    </h2>
                    <p class="text-sm text-slate-600 mt-1">Recevez des rapports automatiques par email</p>
                </div>

                <div class="p-6 space-y-3">
                    <label
                        class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Résumé Quotidien</p>
                            <p class="text-xs text-slate-600">Rapport envoyé chaque jour à 9h00</p>
                        </div>
                        <input type="checkbox" name="send_daily_summary" value="1"
                            {{ old('send_daily_summary', $settings->send_daily_summary) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                    </label>

                    <label
                        class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Rapport Hebdomadaire</p>
                            <p class="text-xs text-slate-600">Rapport envoyé chaque lundi à 9h00</p>
                        </div>
                        <input type="checkbox" name="send_weekly_report" value="1"
                            {{ old('send_weekly_report', $settings->send_weekly_report) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                    </label>
                </div>
            </div>

            <!-- Low Stock Settings -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-orange-100 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Alertes de Stock
                    </h2>
                    <p class="text-sm text-slate-600 mt-1">Configuration des alertes de stock faible</p>
                </div>

                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Activer les Alertes de Stock</p>
                            <p class="text-xs text-slate-600">Recevoir des notifications quand le stock est faible</p>
                        </div>
                        <input type="checkbox" name="alert_on_low_stock" value="1"
                            {{ old('alert_on_low_stock', $settings->alert_on_low_stock) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="max-w-md">
                        <x-admin.setting-field name="low_stock_threshold" label="Seuil de Stock Faible" type="number"
                            :value="$settings->low_stock_threshold" placeholder="10" required
                            help="Quantité en dessous de laquelle une alerte sera envoyée" />
                    </div>
                </div>
            </div>

            <!-- Customer Notifications -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 bg-gradient-to-r from-teal-50 to-teal-100 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Notifications Client
                    </h2>
                    <p class="text-sm text-slate-600 mt-1">Emails automatiques envoyés aux clients</p>
                </div>

                <div class="p-6 space-y-3">
                    <label
                        class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Confirmation de Commande</p>
                            <p class="text-xs text-slate-600">Email envoyé après la création d'une commande</p>
                        </div>
                        <input type="checkbox" name="send_order_confirmation_to_customer" value="1"
                            {{ old('send_order_confirmation_to_customer', $settings->send_order_confirmation_to_customer) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                    </label>

                    <label
                        class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Confirmation de Paiement</p>
                            <p class="text-xs text-slate-600">Email envoyé après un paiement réussi</p>
                        </div>
                        <input type="checkbox" name="send_payment_confirmation_to_customer" value="1"
                            {{ old('send_payment_confirmation_to_customer', $settings->send_payment_confirmation_to_customer) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                    </label>

                    <label
                        class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-100 transition">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Notification d'Expédition</p>
                            <p class="text-xs text-slate-600">Email envoyé lors de l'expédition de la commande</p>
                        </div>
                        <input type="checkbox" name="send_shipping_notification_to_customer" value="1"
                            {{ old('send_shipping_notification_to_customer', $settings->send_shipping_notification_to_customer) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                    </label>
                </div>
            </div>

            <!-- SMS Notifications (Optional) -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-indigo-100 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Notifications SMS
                    </h2>
                    <p class="text-sm text-slate-600 mt-1">Configuration des notifications par SMS (optionnel)</p>
                </div>

                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Activer les SMS</p>
                            <p class="text-xs text-slate-600">Envoyer des notifications par SMS</p>
                        </div>
                        <input type="checkbox" name="sms_notifications_enabled" value="1"
                            {{ old('sms_notifications_enabled', $settings->sms_notifications_enabled) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-admin.setting-field name="sms_provider" label="Fournisseur SMS" type="select" :value="$settings->sms_provider"
                                :options="[
                                    '' => 'Sélectionner',
                                    'twilio' => 'Twilio',
                                    'vonage' => 'Vonage (Nexmo)',
                                    'messagebird' => 'MessageBird',
                                ]" help="Service SMS à utiliser" />
                        </div>

                        <div>
                            <x-admin.setting-field name="admin_phone_number" label="Numéro de Téléphone Admin" type="text"
                                :value="$settings->admin_phone_number" placeholder="+212 6XX XXX XXX" help="Numéro qui recevra les SMS" />
                        </div>

                        <div class="md:col-span-2">
                            <x-admin.setting-field name="sms_api_key" label="Clé API SMS" type="password" :value="$settings->sms_api_key"
                                placeholder="Votre clé API" help="Clé API de votre fournisseur SMS (chiffrée)" />
                        </div>
                    </div>

                    <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-indigo-600 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="flex-1 text-sm text-indigo-800">
                                <p class="font-semibold mb-1">Configuration SMS</p>
                                <p>Les notifications SMS nécessitent un compte chez un fournisseur SMS. Les frais varient
                                    selon le fournisseur et le volume de messages envoyés.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pb-6">
                <x-admin.button href="{{ route('admin.settings.index') }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Annuler
                </x-admin.button>
                <x-admin.button type="submit">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Enregistrer les Modifications
                </x-admin.button>
            </div>
        </form>
    </div>
@endsection

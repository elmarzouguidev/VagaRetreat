@extends('layouts.admin')

@section('title', 'Informations de l’entreprise')
@section('page-title', 'Informations de l’entreprise')

@php
    $businessInfo = $user->businessInfo;
    $missingPayoutRequirements = $businessInfo?->missingPayoutRequirements() ?? collect();
@endphp

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">
        <div class="mb-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Informations de l’entreprise</h1>
                    <p class="mt-1 text-sm text-slate-600">
                        Consultez les coordonnées administratives et bancaires liées à votre compte professionnel.
                    </p>
                </div>

                <div class="flex gap-3">
                    <x-admin.button href="{{ route('admin.profile.business-info.edit') }}" variant="primary">
                        Modifier
                    </x-admin.button>
                    <x-admin.button href="{{ route('admin.profile.index') }}" variant="outline">
                        Retour au profil
                    </x-admin.button>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900">Résumé</h2>
            </div>

            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Compte</dt>
                        <dd class="mt-2 text-base font-semibold text-slate-900">{{ $user->full_name }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-slate-500">Email</dt>
                        <dd class="mt-2 text-base font-semibold text-slate-900">{{ $user->email }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-slate-500">Statut</dt>
                        <dd class="mt-2">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium
                                {{ $businessInfo && $businessInfo->isPayoutReady() ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $businessInfo && $businessInfo->isPayoutReady() ? 'Prêt pour virement' : 'Incomplet' }}
                            </span>
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-slate-500">Validation admin</dt>
                        <dd class="mt-2">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $businessInfo?->reviewStatusColor() ?? 'bg-amber-100 text-amber-700' }}">
                                {{ $businessInfo?->reviewStatusLabel() ?? 'En attente' }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                @if ($businessInfo)
                    <div class="space-y-6">
                        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                            <div class="px-6 py-4 border-b border-slate-200">
                                <h2 class="text-lg font-semibold text-slate-900">État de complétude</h2>
                            </div>

                            <div class="p-6">
                                @if ($businessInfo->isPayoutReady())
                                    <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                                        Les informations requises pour préparer un virement professionnel sont complètes.
                                    </div>
                                @else
                                    <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-4">
                                        <p class="text-sm font-medium text-amber-900">
                                            Des informations sont encore manquantes avant validation du dossier.
                                        </p>

                                        <ul class="mt-3 space-y-1 text-sm text-amber-800">
                                            @foreach ($missingPayoutRequirements as $item)
                                                <li>- {{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (filled($businessInfo->review_note))
                                    <div class="mt-4 rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700">
                                        <p class="font-medium text-slate-900">Note de revue</p>
                                        <p class="mt-1">{{ $businessInfo->review_note }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                            <div class="px-6 py-4 border-b border-slate-200">
                                <h2 class="text-lg font-semibold text-slate-900">Informations bancaires</h2>
                            </div>

                            <div class="p-6">
                                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <dt class="text-sm font-medium text-slate-500">Titulaire du compte</dt>
                                        <dd class="mt-2 text-sm font-semibold text-slate-900">{{ $businessInfo->account_holder ?: 'Non renseigné' }}</dd>
                                    </div>

                                    <div>
                                        <dt class="text-sm font-medium text-slate-500">Banque</dt>
                                        <dd class="mt-2 text-sm font-semibold text-slate-900">{{ $businessInfo->bank_name ?: 'Non renseigné' }}</dd>
                                    </div>

                                    <div>
                                        <dt class="text-sm font-medium text-slate-500">RIB</dt>
                                        <dd class="mt-2 break-all text-sm font-semibold text-slate-900">{{ $businessInfo->rib ?: 'Non renseigné' }}</dd>
                                    </div>

                                    <div>
                                        <dt class="text-sm font-medium text-slate-500">IBAN</dt>
                                        <dd class="mt-2 break-all text-sm font-semibold text-slate-900">{{ $businessInfo->iban_code ?: 'Non renseigné' }}</dd>
                                    </div>

                                    <div>
                                        <dt class="text-sm font-medium text-slate-500">Code SWIFT</dt>
                                        <dd class="mt-2 text-sm font-semibold text-slate-900">{{ $businessInfo->swift_code ?: 'Non renseigné' }}</dd>
                                    </div>

                                    <div class="md:col-span-2">
                                        <dt class="text-sm font-medium text-slate-500">Justificatif de titularité du compte (attestation de RIB)</dt>
                                        <dd class="mt-2 text-sm font-semibold text-slate-900">
                                            @if ($businessInfo->certificateUrl())
                                                <a href="{{ $businessInfo->certificateUrl() }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                    Voir le document
                                                </a>
                                            @else
                                                Non renseigné
                                            @endif
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                            <div class="px-6 py-4 border-b border-slate-200">
                                <h2 class="text-lg font-semibold text-slate-900">Informations société</h2>
                            </div>

                            <div class="p-6">
                                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <dt class="text-sm font-medium text-slate-500">Raison sociale</dt>
                                        <dd class="mt-2 text-sm font-semibold text-slate-900">{{ $businessInfo->legal_name ?: 'Non renseigné' }}</dd>
                                    </div>

                                    <div>
                                        <dt class="text-sm font-medium text-slate-500">ICE</dt>
                                        <dd class="mt-2 text-sm font-semibold text-slate-900">{{ $businessInfo->ice ?: 'Non renseigné' }}</dd>
                                    </div>

                                    <div>
                                        <dt class="text-sm font-medium text-slate-500">RC</dt>
                                        <dd class="mt-2 text-sm font-semibold text-slate-900">{{ $businessInfo->rc ?: 'Non renseigné' }}</dd>
                                    </div>

                                    <div>
                                        <dt class="text-sm font-medium text-slate-500">IF</dt>
                                        <dd class="mt-2 text-sm font-semibold text-slate-900">{{ $businessInfo->if ?: 'Non renseigné' }}</dd>
                                    </div>

                                    <div>
                                        <dt class="text-sm font-medium text-slate-500">Taxe professionnelle</dt>
                                        <dd class="mt-2 text-sm font-semibold text-slate-900">{{ $businessInfo->business_tax ?: 'Non renseigné' }}</dd>
                                    </div>

                                    <div>
                                        <dt class="text-sm font-medium text-slate-500">Email société</dt>
                                        <dd class="mt-2 text-sm font-semibold text-slate-900">{{ $businessInfo->email ?: 'Non renseigné' }}</dd>
                                    </div>

                                    <div>
                                        <dt class="text-sm font-medium text-slate-500">Téléphone société</dt>
                                        <dd class="mt-2 text-sm font-semibold text-slate-900">{{ $businessInfo->telephone ?: 'Non renseigné' }}</dd>
                                    </div>

                                    <div class="md:col-span-2">
                                        <dt class="text-sm font-medium text-slate-500">Adresse légale</dt>
                                        <dd class="mt-2 text-sm font-semibold text-slate-900">{{ $businessInfo->legal_addresse ?: 'Non renseigné' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900">Données enregistrées</h2>
                        </div>

                        <div class="p-6">
                            <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                                Aucune information d’entreprise n’est encore enregistrée pour ce compte professionnel.
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900">Informations utiles</h2>
                    </div>

                    <div class="p-6 space-y-4 text-sm leading-6 text-slate-600">
                        <p>Ces informations sont utilisées pour la gestion administrative et les opérations financières liées à votre activité.</p>
                        <p>Pour être prêt au virement, le dossier doit au minimum contenir la banque, le titulaire, le RIB, l’ICE et le justificatif de titularité.</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900">Accès rapide</h2>
                    </div>

                    <div class="p-6 space-y-3">
                        <a href="{{ route('admin.profile.edit') }}"
                            class="flex items-center justify-between rounded-lg border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                            <span>Modifier mon profil</span>
                            <span class="text-slate-400">Ouvrir</span>
                        </a>

                        <a href="{{ route('admin.profile.settings') }}"
                            class="flex items-center justify-between rounded-lg border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                            <span>Paramètres du compte</span>
                            <span class="text-slate-400">Ouvrir</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

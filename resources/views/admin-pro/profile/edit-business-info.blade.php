@extends('layouts.admin')

@section('title', 'Modifier les informations de l’entreprise')
@section('page-title', 'Modifier les informations de l’entreprise')

@php
    $businessInfo = $user->businessInfo;
    $selectedBank = old('bank_id', $currentBankId);
    $missingPayoutRequirements = $businessInfo?->missingPayoutRequirements() ?? collect();
@endphp

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <x-admin.button href="{{ route('admin.profile.business-info') }}" variant="outline">
                Retour aux informations de l’entreprise
            </x-admin.button>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900">Mettre à jour les informations de l’entreprise</h2>
            </div>

            <form action="{{ route('admin.profile.business-info.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                @if ($businessInfo && ! $businessInfo->isPayoutReady())
                    <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-4">
                        <p class="text-sm font-medium text-amber-900">
                            Les éléments suivants sont encore requis pour rendre le dossier prêt au virement :
                        </p>

                        <ul class="mt-3 space-y-1 text-sm text-amber-800">
                            @foreach ($missingPayoutRequirements as $item)
                                <li>- {{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="rounded-lg border border-slate-200">
                    <div class="px-5 py-4 border-b border-slate-200 bg-slate-50">
                        <h3 class="text-base font-semibold text-slate-900">Informations bancaires</h3>
                        <p class="mt-1 text-sm text-slate-600">Renseignez les coordonnées du compte utilisé pour votre activité professionnelle.</p>
                    </div>

                    <div class="p-5 space-y-6">
                        <div class="grid gap-6 md:grid-cols-2">
                            <x-admin.form-select
                                label="Banque"
                                name="bank_id"
                                :options="$banks"
                                :value="$selectedBank"
                                placeholder="Sélectionner une banque"
                                required
                            />

                            <x-admin.form-input
                                label="Titulaire du compte"
                                name="account_holder"
                                :value="old('account_holder', $businessInfo?->account_holder)"
                                required
                            />
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <x-admin.form-input
                                label="RIB"
                                name="rib"
                                :value="old('rib', $businessInfo?->rib)"
                                required
                            />

                            <x-admin.form-input
                                label="IBAN"
                                name="iban_code"
                                :value="old('iban_code', $businessInfo?->iban_code)"
                            />
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <x-admin.form-input
                                label="Code SWIFT"
                                name="swift_code"
                                :value="old('swift_code', $businessInfo?->swift_code)"
                            />
                        </div>

                        <div>
                            <label for="bank_account_ownership_certificate"
                                class="mb-2 block text-sm font-medium text-slate-900">
                                Justificatif de titularité du compte
                            </label>

                            <label for="bank_account_ownership_certificate"
                                class="flex cursor-pointer items-start gap-4 rounded-lg border border-dashed border-slate-300 bg-slate-50 px-4 py-4 transition hover:border-blue-400 hover:bg-blue-50">
                                <span
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-white text-slate-500 shadow-sm ring-1 ring-slate-200">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </span>

                                <span class="min-w-0 flex-1">
                                    <span class="block text-sm font-medium text-slate-900">
                                        Télécharger un fichier
                                    </span>
                                    <span class="mt-1 block text-sm text-slate-600">
                                        Formats acceptés : image ou PDF. Taille maximale : 5 Mo.
                                    </span>

                                    @if ($businessInfo?->certificateUrl())
                                        <span class="mt-3 block text-sm text-slate-700">
                                            Fichier actuel :
                                            <a href="{{ $businessInfo->certificateUrl() }}" target="_blank"
                                                rel="noopener" class="font-medium text-blue-600 hover:text-blue-800">
                                                Ouvrir le justificatif
                                            </a>
                                        </span>
                                    @endif
                                </span>
                            </label>

                            <input id="bank_account_ownership_certificate" name="bank_account_ownership_certificate"
                                type="file" accept="image/*,.pdf" class="sr-only">

                            @error('bank_account_ownership_certificate')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-slate-200">
                    <div class="px-5 py-4 border-b border-slate-200 bg-slate-50">
                        <h3 class="text-base font-semibold text-slate-900">Informations société</h3>
                        <p class="mt-1 text-sm text-slate-600">Renseignez les informations administratives de votre société.</p>
                    </div>

                    <div class="p-5 space-y-6">
                        <div class="grid gap-6 md:grid-cols-2">
                            <x-admin.form-input
                                label="Raison sociale"
                                name="legal_name"
                                :value="old('legal_name', $businessInfo?->legal_name)"
                            />

                            <x-admin.form-input
                                label="ICE"
                                name="ice"
                                :value="old('ice', $businessInfo?->ice)"
                                required
                            />
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <x-admin.form-input
                                label="RC"
                                name="rc"
                                :value="old('rc', $businessInfo?->rc)"
                            />

                            <x-admin.form-input
                                label="IF"
                                name="if"
                                :value="old('if', $businessInfo?->if)"
                            />
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <x-admin.form-input
                                label="Taxe professionnelle"
                                name="business_tax"
                                :value="old('business_tax', $businessInfo?->business_tax)"
                            />

                            <x-admin.form-input
                                label="Téléphone société"
                                name="telephone"
                                :value="old('telephone', $businessInfo?->telephone)"
                            />
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <x-admin.form-input
                                label="Email société"
                                name="email"
                                type="email"
                                :value="old('email', $businessInfo?->email)"
                            />

                            <x-admin.form-input
                                label="Adresse légale"
                                name="legal_addresse"
                                :value="old('legal_addresse', $businessInfo?->legal_addresse)"
                            />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.profile.business-info') }}" variant="outline">
                        Annuler
                    </x-admin.button>
                    <x-admin.button type="submit" variant="primary">
                        Enregistrer
                    </x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

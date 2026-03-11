@php
    $businessInfo = $user->businessInfo;
    $missingPayoutRequirements = $businessInfo?->missingPayoutRequirements() ?? collect();
@endphp

<div class="bg-white rounded-lg shadow-sm border border-slate-200">
    <div class="px-6 py-4 border-b border-slate-200">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-lg font-semibold text-slate-900">Informations professionnelles</h2>

            <div class="flex flex-wrap gap-2">
                <span
                    class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $businessInfo && $businessInfo->isPayoutReady() ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                    {{ $businessInfo && $businessInfo->isPayoutReady() ? 'Prêt pour virement' : 'Incomplet' }}
                </span>

                @if ($businessInfo)
                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $businessInfo->reviewStatusColor() }}">
                        {{ $businessInfo->reviewStatusLabel() }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="p-6">
        @if ($businessInfo)
            @if ($missingPayoutRequirements->isNotEmpty())
                <div class="mb-6 rounded-lg border border-amber-200 bg-amber-50 px-4 py-4">
                    <p class="text-sm font-medium text-amber-900">
                        Éléments encore manquants pour considérer ce dossier comme prêt au virement :
                    </p>

                    <ul class="mt-3 space-y-1 text-sm text-amber-800">
                        @foreach ($missingPayoutRequirements as $item)
                            <li>- {{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (filled($businessInfo->review_note))
                <div class="mb-6 rounded-lg border border-slate-200 bg-slate-50 px-4 py-4">
                    <p class="text-sm font-medium text-slate-900">Note de revue</p>
                    <p class="mt-2 text-sm text-slate-700">{{ $businessInfo->review_note }}</p>
                </div>
            @endif

            <div class="mb-6 rounded-lg border border-slate-200 bg-white">
                <div class="border-b border-slate-200 px-4 py-3">
                    <h3 class="text-sm font-semibold text-slate-900">Validation du dossier</h3>
                </div>

                <form action="{{ route('admin.users.business-info.review', $user) }}" method="POST" class="space-y-4 p-4">
                    @csrf

                    <div>
                        <label for="review_note" class="mb-2 block text-sm font-medium text-slate-700">
                            Note de revue
                        </label>
                        <textarea id="review_note" name="review_note" rows="4"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                            placeholder="Ajoutez un commentaire pour l’équipe ou le professionnel...">{{ old('review_note', $businessInfo->review_note) }}</textarea>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <button type="submit" formaction="{{ route('admin.users.business-info.approve', $user) }}"
                            class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-700">
                            Approuver
                        </button>

                        <button type="submit" formaction="{{ route('admin.users.business-info.reject', $user) }}"
                            class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700">
                            Rejeter
                        </button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h3 class="text-sm font-semibold text-slate-900">Informations bancaires</h3>

                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Banque</dt>
                            <dd class="text-sm text-slate-900">{{ $businessInfo->bank_name ?: 'Non renseigné' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Titulaire du compte</dt>
                            <dd class="text-sm text-slate-900">
                                {{ $businessInfo->account_holder ?: 'Non renseigné' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">RIB</dt>
                            <dd class="text-sm text-slate-900">{{ $businessInfo->rib ?: 'Non renseigné' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">IBAN</dt>
                            <dd class="text-sm text-slate-900">{{ $businessInfo->iban_code ?: 'Non renseigné' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">SWIFT</dt>
                            <dd class="text-sm text-slate-900">
                                {{ $businessInfo->swift_code ?: 'Non renseigné' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Justificatif de titularité</dt>
                            <dd class="text-sm text-slate-900">
                                @if ($businessInfo->certificateUrl())
                                    <a href="{{ $businessInfo->certificateUrl() }}" target="_blank" rel="noopener"
                                        class="text-blue-600 hover:text-blue-800">
                                        Voir le document
                                    </a>
                                @else
                                    Non renseigné
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="space-y-4">
                    <h3 class="text-sm font-semibold text-slate-900">Informations société</h3>

                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Raison sociale</dt>
                            <dd class="text-sm text-slate-900">{{ $businessInfo->legal_name ?: 'Non renseigné' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">ICE</dt>
                            <dd class="text-sm text-slate-900">{{ $businessInfo->ice ?: 'Non renseigné' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">RC</dt>
                            <dd class="text-sm text-slate-900">{{ $businessInfo->rc ?: 'Non renseigné' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">IF</dt>
                            <dd class="text-sm text-slate-900">{{ $businessInfo->if ?: 'Non renseigné' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Taxe professionnelle</dt>
                            <dd class="text-sm text-slate-900">
                                {{ $businessInfo->business_tax ?: 'Non renseigné' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Adresse légale</dt>
                            <dd class="text-sm text-slate-900">
                                {{ $businessInfo->legal_addresse ?: 'Non renseigné' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Email société</dt>
                            <dd class="text-sm text-slate-900">{{ $businessInfo->email ?: 'Non renseigné' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Téléphone société</dt>
                            <dd class="text-sm text-slate-900">
                                {{ $businessInfo->telephone ?: 'Non renseigné' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        @else
            <p class="text-sm text-slate-500">Aucune information professionnelle renseignée.</p>
        @endif
    </div>
</div>

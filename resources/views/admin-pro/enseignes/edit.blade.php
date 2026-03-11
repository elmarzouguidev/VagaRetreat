@extends('layouts.admin')

@section('title', 'Modifier Enseigne')
@section('page-title', 'Modifier l\'enseigne')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <x-admin.button href="{{ route('admin.enseignes.index') }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour aux Enseignes
                </x-admin.button>

                <div class="flex gap-2">
                    <x-admin.button href="{{ route('admin.enseignes.show', $enseigne) }}" variant="outline">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Voir l'Enseigne
                    </x-admin.button>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" name="updateForm" action="{{ route('admin.enseignes.update', $enseigne) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @honeypot

            <div class="space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900">Informations Générales</h2>
                        <p class="mt-1 text-sm text-slate-600">Renseignez les informations de base de l'enseigne</p>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Name -->
                        <x-admin.form-input label="Nom de l'Enseigne" name="name"
                            placeholder="Ex: Restaurant Le Bon Coin" required :value="old('name', $enseigne->name)" />

                        <!-- Code -->
                        <x-admin.form-input label="Code" name="code" placeholder="Ex: RBC-001"
                            helper="Code unique pour identifier l'enseigne" required :value="old('code', $enseigne->code)" />

                        <!-- Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-slate-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Type d'Enseigne <span class="text-red-500">*</span>
                            </label>
                            <select id="type" name="type" required
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('type') border-red-500 @enderror">
                                <option value="">Sélectionnez un type</option>
                                @foreach ($types ?? [] as $type)
                                    <option value="{{ $type->id }}" @selected(old('type', $enseigne->enseigne_type_id) == $type->id)>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Professional (Admin Only) -->
                        @hasrole(\App\Enums\Roles\RolesEnums::SUPERADMIN)
                            <div>
                                <label for="user" class="block text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Professionnel <span class="text-red-500">*</span>
                                </label>
                                <select id="user" name="user" required
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('user') border-red-500 @enderror">
                                    <option value="">Sélectionnez un professionnel</option>
                                    @foreach ($professionals ?? [] as $professional)
                                        <option value="{{ $professional->id }}" @selected(old('user', $enseigne->user_id) == $professional->id)>
                                            {{ $professional->full_name }} - {{ $professional->email }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endhasrole

                        <!-- Description -->
                        <x-admin.textarea label="Description" name="content" placeholder="Description de l'enseigne..."
                            rows="4" :value="old('content', $enseigne->content)" />

                        <!-- Logo -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Logo
                            </label>
                            <div class="mt-1 flex items-center gap-4">
                                <div class="flex-shrink-0">
                                    <div id="logo-preview"
                                        class="h-20 w-20 rounded-lg border-2 border-slate-300 overflow-hidden bg-slate-50">
                                        @if ($enseigne->getFirstMediaUrl('enseignes_logo'))
                                            <img src="{{ $enseigne->getFirstMediaUrl('enseignes_logo') }}"
                                                class="h-full w-full object-cover" alt="{{ $enseigne->name }}">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <input type="file" id="logo" name="logo"
                                        accept="image/jpeg,image/png,image/jpg,image/webp"
                                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition @error('logo') border-red-500 @enderror"
                                        onchange="previewLogo(event)">
                                    <p class="mt-1 text-xs text-slate-500">PNG, JPG, WEBP jusqu'à 2MB. Laissez vide pour
                                        conserver le logo actuel.</p>
                                    @error('logo')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            @if ($enseigne->getFirstMediaUrl('enseignes_logos'))
                                <div class="mt-2">
                                    <label class="flex items-center gap-2 text-sm text-slate-600">
                                        <input type="checkbox" name="remove_logo" value="1"
                                            class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                        Supprimer le logo actuel
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900">Coordonnées</h2>
                        <p class="mt-1 text-sm text-slate-600">Informations de contact de l'enseigne</p>
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Email -->
                            <x-admin.form-input label="E-mail" name="email" type="email"
                                placeholder="contact@enseigne.com" required :value="old('email', $enseigne->email)" />

                            <!-- Phone -->
                            <x-admin.form-input label="Téléphone" name="telephone" type="tel"
                                placeholder="0612345678" required :value="old('telephone', $enseigne->telephone)" />
                        </div>

                        <!-- Website -->
                        <x-admin.form-input label="Site Web" name="website" type="url"
                            placeholder="https://www.enseigne.com" :value="old('website', $enseigne->website)" />

                        <!-- Address -->
                        <x-admin.textarea label="Adresse" name="address" placeholder="Adresse complète de l'enseigne..."
                            rows="3" required :value="old('address', $enseigne->address)" />

                        <!-- City -->
                        <div>
                            <label for="city" class="block text-sm font-medium text-slate-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Ville <span class="text-red-500">*</span>
                            </label>
                            <select id="city" name="city" required
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('city') border-red-500 @enderror">
                                <option value="">Sélectionnez une ville</option>
                                @foreach ($cities ?? [] as $city)
                                    <option value="{{ $city->id }}" @selected(old('city', $enseigne->city_id) == $city->id)>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Business Information -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900">Informations Commerciales</h2>
                        <p class="mt-1 text-sm text-slate-600">Détails commerciaux et réglementaires</p>
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- SIRET -->
                            <x-admin.form-input label="SIRET / ICE" name="ice" placeholder="12345678901234"
                                helper="Numéro d'identification de l'entreprise" :value="old('address', $enseigne->ice)" />

                            <!-- TVA Number -->
                            <x-admin.form-input label="Numéro de TVA" name="rc" placeholder="FR12345678901"
                                :value="old('address', $enseigne->rc)" />
                        </div>

                        <!-- Opening Hours -->
                        <x-admin.textarea label="Horaires d'Ouverture" name="opening_hours"
                            placeholder="Lun-Ven: 9h-18h&#10;Sam: 10h-16h&#10;Dim: Fermé" rows="4"
                            helper="Indiquez les horaires d'ouverture de l'enseigne" :value="old('opening_hours')" />

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Statut <span class="text-red-500">*</span>
                            </label>
                            <select id="status" name="status" required
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('status') border-red-500 @enderror">
                                @foreach ($statuses ?? [] as $status)
                                    <option value="{{ $status->value }}" @selected(old('status', $enseigne->status?->value) == $status->value)>
                                        {{ $status->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Metadata Section -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900">Informations Système</h2>
                        <p class="mt-1 text-sm text-slate-600">Métadonnées et informations de suivi</p>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Créé le</label>
                                <p class="text-sm text-slate-900">{{ $enseigne->created_at?->format('d/m/Y à H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Dernière modification</label>
                                <p class="text-sm text-slate-900">{{ $enseigne->updated_at?->format('d/m/Y à H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">UUID</label>
                                <p class="text-xs text-slate-600 font-mono">{{ $enseigne->uuid }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">ID</label>
                                <p class="text-sm text-slate-900">#{{ $enseigne->id }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div
                    class="flex items-center justify-between bg-white rounded-lg shadow-sm border border-slate-200 px-6 py-4">
                    <div class="flex gap-2">
                        <x-admin.button href="{{ route('admin.enseignes.index') }}" variant="outline">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Annuler
                        </x-admin.button>

                        {{-- @can('delete', $enseigne)
                            <form method="POST" action="{{ route('admin.enseignes.delete') }}"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette enseigne ? Cette action est irréversible.')">
                                @csrf
                                @method('DELETE')
                                @honeypot
                                <input type="hidden" name="enseigne" value="{{ $enseigne->uuid }}">
                                <x-admin.button type="submit" variant="danger">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Supprimer
                                </x-admin.button>
                            </form>
                        @endcan --}}
                    </div>

                    <div class="flex gap-3">
                        <x-admin.button type="submit" name="save_and_continue" value="1" variant="outline">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Enregistrer et Continuer
                        </x-admin.button>

                        <x-admin.button type="submit" variant="primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Mettre à Jour
                        </x-admin.button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function previewLogo(event) {
                const preview = document.getElementById('logo-preview');
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.innerHTML =
                            `<img src="${e.target.result}" class="h-full w-full object-cover" alt="Logo preview">`;
                    }
                    reader.readAsDataURL(file);
                }
            }
        </script>
    @endpush
@endsection

@extends('layouts.admin')

@section('title', 'Editer un panier')
@section('page-title', 'Editer un panier')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center space-x-4">
                <x-admin.button href="{{ route('admin.paniers.index') }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour aux paniers
                </x-admin.button>
            </div>
        </div>

        <!-- Form -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="text-lg font-medium text-gray-900">Détails du panier</h2>
                <p class="mt-1 text-sm text-gray-600">Remplissez les informations ci-dessous pour editer le panier.
                </p>
            </div>

            <form method="POST" action="{{ route('admin.paniers.update', $panier) }}" enctype="multipart/form-data"
                class="p-6 space-y-6">
                @csrf
                @honeypot
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-3 space-y-6">
                        <x-admin.form-input label="Nom" name="name" :value="$panier->name" required />

                        <x-admin.textarea label="Description" name="content" placeholder="Brève description du panier"
                            :value="$panier->content" rows="3" />
                        <x-admin.form-input label="Quantité disponible" name="quantity" type="number" :value="$panier->quantity"
                            placeholder="Quantité disponible" required />

                        <x-admin.form-input label="Prix" name="price" step="0.1" type="number" placeholder="Prix"
                            :value="$panier->price" required />

                        <!-- DATE Section -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Paramètres de Panier</h3>

                            <x-admin.form-input label="Jour de collecte" name="collect_day" placeholder="Jour de collecte"
                                :value="$panier->collect_day?->format('d-m-Y')" required />

                            <x-admin.form-input label="Heure de collecte (début)" name="collect_time_start"
                                :value="$panier->collect_time_start?->format('H:i')" placeholder="heure de collecte (début)" required />

                            <x-admin.form-input label="Heure de collecte (fin)" name="collect_time_end" :value="$panier->collect_time_end?->format('H:i')"
                                placeholder="heure de collecte (fin)" required />

                            <x-admin.textarea label="Adresse de collecte" name="collect_address" :value="$panier->collect_address"
                                placeholder="Adresse de collecte" rows="3" required />
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Publish Settings -->
                        <div class="admin-inset p-4">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Status</h3>
                            <x-admin.form-select label="Status" name="status" :options="$options" :value="$panier->status->value()"
                                required />
                        </div>

                        <!-- Enseigne & Tags -->
                        <div class="admin-inset p-4">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Enseigne</h3>

                            <x-admin.form-select label="Enseigne" name="enseigne" placeholder="Select a enseigne" required>
                                @foreach ($enseignes ?? [] as $enseigne)
                                    <option value="{{ $enseigne->id }}" @selected($panier->enseigne_id == $enseigne->id ?? old('enseigne'))>{{ $enseigne->name }}
                                    </option>
                                @endforeach
                            </x-admin.form-select>

                            <x-admin.form-select label="Type" name="type" placeholder="Select a type" required>
                                @foreach ($types ?? [] as $type)
                                    <option value="{{ $type->id }}" @selected($panier->panier_type_id == $type->id ?? old('type'))>{{ $type->name }}
                                    </option>
                                @endforeach
                            </x-admin.form-select>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                                <div
                                    class="space-y-2 max-h-32 overflow-y-auto border border-slate-200/70 rounded-lg p-3 bg-white/70">
                                    @foreach ($tags ?? [] as $tag)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                                @checked(request('tag') ? request()->collect('tag')->contains($tag->id) : false) class="admin-checkbox">
                                            <span class="ml-2 text-sm text-gray-700">{{ $tag->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('tags')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <div class="admin-inset p-4">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Image mise en avant</h3>

                            <x-admin.file-upload name="cover_photo" label="Upload Image" accept="image/*" maxSize="2MB" />
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-slate-200/70">
                    <x-admin.button href="{{ route('admin.paniers.index') }}" variant="outline">
                        Annuler
                    </x-admin.button>

                    <div class="flex space-x-3">
                        <x-admin.button type="submit" variant="primary">
                            Enregistrer le panier
                        </x-admin.button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

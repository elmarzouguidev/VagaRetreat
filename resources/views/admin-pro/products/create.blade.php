@extends('layouts.admin')

@section('title', 'Créer un produit')
@section('page-title', 'Créer un nouveau produit')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <x-admin.button href="{{ route('admin.products.index') }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour aux produits
                </x-admin.button>

                <div class="text-sm text-slate-500">
                    <span class="text-red-500">*</span> Champs obligatoires
                </div>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data"
            x-data="productForm()" @submit="validateForm">
            @csrf
            @honeypot

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-3 space-y-6">

                    <!-- Basic Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900">Informations de base</h2>
                            <p class="mt-1 text-sm text-slate-600">Détails principaux du produit</p>
                        </div>

                        <div class="p-6 space-y-5">
                            <!-- Name -->
                            <div>
                                <x-admin.form-input label="Nom du produit" name="name" placeholder="ex: Pain complet bio"
                                    x-model="name" @input="generateCode" required autofocus />
                                <p class="mt-1 text-xs text-slate-500">
                                    Nom descriptif du produit qui sera affiché aux clients
                                </p>
                            </div>

                            <!-- Description -->
                            <div>
                                <x-admin.textarea label="Description" name="content"
                                    placeholder="Décrivez le produit, ses caractéristiques, ingrédients..." rows="4"
                                    x-model="description" />
                                <div class="mt-1 flex items-center justify-between text-xs">
                                    <span class="text-slate-500">Description visible par les clients</span>
                                    <span class="text-slate-400" x-text="description.length + ' caractères'"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Stock -->
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900">Prix et stock</h2>
                            <p class="mt-1 text-sm text-slate-600">Gestion des prix et quantités</p>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Price -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                        Prix <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="price" step="0.01" min="0"
                                            placeholder="0.00" x-model.number="price" required
                                            class="w-full px-4 py-2.5 pr-16 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <span class="text-slate-500 font-medium">MAD</span>
                                        </div>
                                    </div>
                                    @error('price')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-slate-500">Prix unitaire du produit</p>
                                </div>

                                <!-- Quantity -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                        Quantité en stock <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="quantity" min="0" placeholder="0"
                                        x-model.number="quantity" required
                                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('quantity')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror

                                    <!-- Stock Warning -->
                                    <div x-show="quantity > 0 && quantity < 10"
                                        class="mt-2 flex items-center gap-2 text-xs text-orange-600 bg-orange-50 px-3 py-2 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <span>Stock faible</span>
                                    </div>

                                    <div x-show="quantity === 0"
                                        class="mt-2 flex items-center gap-2 text-xs text-red-600 bg-red-50 px-3 py-2 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Produit en rupture de stock</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Value Display -->
                            <div
                                class="mt-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-slate-700">Valeur totale du stock</span>
                                    <span class="text-lg font-bold text-blue-600"
                                        x-text="formatPrice(price * quantity)"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Settings -->
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900">Paramètres du produit</h2>
                        </div>

                        <div class="p-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Code produit
                                </label>
                                <input type="text" name="code" placeholder="Code unique (auto-généré si vide)"
                                    x-model="code"
                                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm">
                                @error('code')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-slate-500">
                                    Code unique pour identifier le produit (SKU). Laissez vide pour génération automatique.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">

                    <!-- Owner (SuperAdmin Only) -->
                    @can('manage-all-products')
                        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                            <div class="px-4 py-3 border-b border-slate-200 bg-slate-50">
                                <h3 class="text-sm font-semibold text-slate-900">Propriétaire</h3>
                            </div>
                            <div class="p-4">
                                <x-admin.form-select label="Professionnel" name="user"
                                    placeholder="Sélectionner un utilisateur" required>
                                    @foreach ($users ?? [] as $user)
                                        <option value="{{ $user->id }}" @selected(old('user') == $user->id)>
                                            {{ $user->full_name }}
                                        </option>
                                    @endforeach
                                </x-admin.form-select>
                            </div>
                        </div>
                    @endcan

                    <!-- Status -->
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-4 py-3 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-sm font-semibold text-slate-900">Publication</h3>
                        </div>
                        <div class="p-4">
                            <x-admin.form-select label="Statut" name="status" :options="$options" value="draft"
                                required />
                            <p class="mt-2 text-xs text-slate-500">
                                Seuls les produits "Publié" sont visibles par les clients
                            </p>
                        </div>
                    </div>

                    <!-- Enseigne -->
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-4 py-3 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-sm font-semibold text-slate-900">Enseigne</h3>
                        </div>
                        <div class="p-4">
                            <x-admin.form-select label="Enseigne" name="enseigne" placeholder="Sélectionner une enseigne"
                                required>
                                @foreach ($enseignes ?? [] as $enseigne)
                                    <option value="{{ $enseigne->id }}" @selected(old('enseigne') == $enseigne->id)>
                                        {{ $enseigne->name }}
                                    </option>
                                @endforeach
                            </x-admin.form-select>
                        </div>
                    </div>

                    <!-- Type -->
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-4 py-3 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-sm font-semibold text-slate-900">Type de produit</h3>
                        </div>
                        <div class="p-4">
                            <x-admin.form-select label="Type" name="type" placeholder="Sélectionner un type"
                                required>
                                @foreach ($types ?? [] as $type)
                                    <option value="{{ $type->id }}" @selected(old('type') == $type->id)>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </x-admin.form-select>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-4 py-3 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-sm font-semibold text-slate-900">Tags</h3>
                        </div>
                        <div class="p-4">
                            <label class="block text-sm font-medium text-slate-700 mb-3">
                                Sélectionner les tags
                            </label>
                            <div
                                class="space-y-2 max-h-48 overflow-y-auto border border-slate-200 rounded-lg p-3 bg-slate-50">
                                @forelse($tags ?? [] as $tag)
                                    <label
                                        class="flex items-center hover:bg-white px-2 py-1.5 rounded transition cursor-pointer">
                                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                            @checked(collect(old('tags', []))->contains($tag->id))
                                            class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                                        <span class="ml-3 text-sm text-slate-700">{{ $tag->name }}</span>
                                    </label>
                                @empty
                                    <p class="text-sm text-slate-500 text-center py-2">Aucun tag disponible</p>
                                @endforelse
                            </div>
                            @error('tags')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-slate-500">
                                Les tags aident à catégoriser et filtrer les produits
                            </p>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-4 py-3 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-sm font-semibold text-slate-900">Image du produit</h3>
                        </div>
                        <div class="p-4">
                            <x-admin.file-upload name="photo" label="Choisir une image" accept="image/*"
                                maxSize="2MB" />
                            <p class="mt-2 text-xs text-slate-500">
                                Formats acceptés: JPG, PNG, WebP. Taille max: 2MB
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-6 bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <x-admin.button href="{{ route('admin.products.index') }}" variant="outline">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Annuler
                    </x-admin.button>

                    <div class="flex items-center gap-3">
                        <x-admin.button type="submit" variant="primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Créer le produit
                        </x-admin.button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function productForm() {
            return {
                name: '{{ old('name', '') }}',
                description: '{{ old('content', '') }}',
                price: {{ old('price', 0) }},
                quantity: {{ old('quantity', 0) }},
                code: '{{ old('code', '') }}',

                // Generate code from name
                generateCode() {
                    if (!this.code) {
                        const slug = this.name
                            .toLowerCase()
                            .normalize('NFD')
                            .replace(/[\u0300-\u036f]/g, '')
                            .replace(/[^a-z0-9]+/g, '-')
                            .replace(/^-+|-+$/g, '');

                        const random = Math.random().toString(36).substring(2, 6).toUpperCase();
                        this.code = `PRD-${slug}-${random}`.substring(0, 50);
                    }
                },

                // Format price with MAD
                formatPrice(value) {
                    if (!value || value === 0) return '0.00 MAD';
                    return value.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ' ') + ' MAD';
                },

                // Validate form before submit
                validateForm(e) {
                    if (!this.name || !this.price || this.quantity < 0) {
                        e.preventDefault();
                        alert('Veuillez remplir tous les champs obligatoires');
                        return false;
                    }
                    return true;
                }
            };
        }
    </script>
@endpush

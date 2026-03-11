@extends('layouts.admin')

@section('title', 'Éditer le produit')
@section('page-title', 'Éditer le produit')

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

                <div class="flex items-center gap-3">
                    <span class="text-sm text-slate-500">
                        <span class="text-red-500">*</span> Champs obligatoires
                    </span>
                    <a href="{{ route('admin.products.show', $product) }}"
                        class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Voir le produit
                    </a>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data"
            x-data="productForm()" @submit="validateForm">
            @csrf
            @honeypot
            @method('PUT')

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
                                    :value="$product->name" x-model="name" required autofocus />
                                <p class="mt-1 text-xs text-slate-500">
                                    Nom descriptif du produit qui sera affiché aux clients
                                </p>
                            </div>

                            <!-- Description -->
                            <div>
                                <x-admin.textarea label="Description" name="content"
                                    placeholder="Décrivez le produit, ses caractéristiques, ingrédients..."
                                    :value="$product->content" rows="4" x-model="description" />
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
                                            placeholder="0.00" value="{{ old('price', $product->price) }}"
                                            x-model.number="price" required
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
                                        value="{{ old('quantity', $product->quantity) }}" x-model.number="quantity" required
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

                            <!-- Stock Change Info -->
                            <div
                                class="mt-4 p-4 bg-gradient-to-r from-slate-50 to-slate-100 rounded-lg border border-slate-200">
                                <div class="flex items-center justify-between text-sm">
                                    <div>
                                        <span class="text-slate-600">Stock actuel en BDD:</span>
                                        <span class="ml-2 font-semibold text-slate-900">{{ $product->quantity }}</span>
                                    </div>
                                    <div x-show="quantity !== {{ $product->quantity }}">
                                        <span class="text-slate-600">Nouveau stock:</span>
                                        <span class="ml-2 font-semibold"
                                            :class="quantity > {{ $product->quantity }} ? 'text-green-600' : 'text-red-600'"
                                            x-text="quantity"></span>
                                        <span class="ml-1"
                                            :class="quantity > {{ $product->quantity }} ? 'text-green-600' : 'text-red-600'"
                                            x-text="quantity > {{ $product->quantity }} ? '↑' : '↓'"></span>
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
                                <input type="text" name="code" placeholder="Code unique"
                                    value="{{ old('code', $product->code) }}" x-model="code"
                                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm bg-slate-50">
                                @error('code')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-slate-500">
                                    Code unique pour identifier le produit (SKU)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">

                    <!-- Status -->
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-4 py-3 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-sm font-semibold text-slate-900">Publication</h3>
                        </div>
                        <div class="p-4">
                            <x-admin.form-select label="Statut" name="status" :options="$options" :value="old('status', $product->status?->value)"
                                required />
                            <p class="mt-2 text-xs text-slate-500">
                                Seuls les produits "Publié" sont visibles par les clients
                            </p>
                        </div>
                    </div>

                    <!-- Current Image Preview -->
                    @if ($product->getFirstMediaUrl('products_photos'))
                        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                            <div class="px-4 py-3 border-b border-slate-200 bg-slate-50">
                                <h3 class="text-sm font-semibold text-slate-900">Image actuelle</h3>
                            </div>
                            <div class="p-4">
                                <div class="relative group">
                                    <img src="{{ $product->getFirstMediaUrl('products_photos') }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-48 object-cover rounded-lg border border-slate-200">
                                    <div
                                        class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                        <a href="{{ $product->getFirstMediaUrl('products_photos') }}" target="_blank"
                                            class="text-white text-sm font-medium flex items-center gap-2 px-4 py-2 bg-white/20 rounded-lg hover:bg-white/30 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                            </svg>
                                            Agrandir
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Enseigne -->
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-4 py-3 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-sm font-semibold text-slate-900">Enseigne</h3>
                        </div>
                        <div class="p-4">
                            <x-admin.form-select label="Enseigne" name="enseigne" placeholder="Sélectionner une enseigne"
                                required>
                                @foreach ($enseignes ?? [] as $enseigne)
                                    <option value="{{ $enseigne->id }}" @selected(old('enseigne', $product->enseigne_id) == $enseigne->id)>
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
                                    <option value="{{ $type->id }}" @selected(old('type', $product->product_type_id) == $type->id)>
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
                                            @checked(collect(old('tags', $product->tags->pluck('id')->toArray()))->contains($tag->id))
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
                            @isset($product->tags)
                                <p class="mt-2 text-xs text-slate-500">
                                    Tags actuels:
                                    <span class="font-medium">
                                        {{ $product->tags->count() > 0 ? $product->tags->pluck('name')->join(', ') : 'Aucun' }}
                                    </span>
                                </p>
                            @endisset
                        </div>
                    </div>

                    <!-- Update Image -->
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-4 py-3 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-sm font-semibold text-slate-900">
                                {{ $product->getFirstMediaUrl('products_photos') ? 'Remplacer l\'image' : 'Ajouter une image' }}
                            </h3>
                        </div>
                        <div class="p-4">
                            <x-admin.file-upload name="photo" label="Choisir une nouvelle image" accept="image/*"
                                maxSize="2MB" />
                            <p class="mt-2 text-xs text-slate-500">
                                Formats acceptés: JPG, PNG, WebP. Taille max: 2MB
                            </p>
                            @if ($product->getFirstMediaUrl('products_photos'))
                                <p class="mt-2 text-xs text-amber-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    L'image actuelle sera remplacée
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-lg border border-slate-200 p-4">
                        <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">
                            Informations
                        </h3>
                        <div class="space-y-2 text-xs text-slate-600">
                            <div class="flex justify-between">
                                <span>Créé le:</span>
                                <span
                                    class="font-medium text-slate-900">{{ $product->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Modifié le:</span>
                                <span
                                    class="font-medium text-slate-900">{{ $product->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if ($product->user)
                                <div class="flex justify-between">
                                    <span>Propriétaire:</span>
                                    <span class="font-medium text-slate-900">{{ $product->user->full_name }}</span>
                                </div>
                            @endif
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
                            Mettre à jour le produit
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
                name: @json(old('name', $product->name)),
                description: @json(old('content', $product->content)),
                price: @json(old('price', $product->price)),
                quantity: @json(old('quantity', $product->quantity)),
                code: @json(old('code', $product->code)),
                formatPrice(value) {
                    if (!value || value === 0) return '0.00 {{ paymentSettings()->payment_currency ?? 'MAD' }}';
                    return Number(value).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ' ') +
                        ' {{ paymentSettings()->payment_currency ?? 'MAD' }}';
                },
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

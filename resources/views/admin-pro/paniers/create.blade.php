@extends('layouts.admin')

@section('title', 'Créer un panier')
@section('page-title', 'Créer un nouveau panier')

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
                <p class="mt-1 text-sm text-gray-600">Remplissez les informations ci-dessous pour créer un nouveau panier.
                </p>
            </div>

            <form method="POST" action="{{ route('admin.paniers.store') }}" enctype="multipart/form-data"
                class="p-6 space-y-6" id="panierForm">
                @csrf
                @honeypot

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-3 space-y-6">
                        <x-admin.form-input label="Nom" name="name" placeholder="Saisir le nom du panier"
                            value='Panier surprise' required />

                        <x-admin.textarea label="Description" name="content" placeholder="Brève description du panier"
                            value='Panier surprise' rows="3" />

                        <x-admin.form-input label="Quantité disponible" name="quantity" type="number"
                            placeholder="Quantité disponible" value="1" required />

                        <!-- Pricing Section -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Tarification</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-admin.form-input label="Prix de base (MAD)" name="base_price" type="number"
                                        step="0.01" placeholder="200.00" id="base_price" required />
                                </div>

                                <div>
                                    <x-admin.form-input label="Réduction (%)" name="discount_percentage" type="number"
                                        step="1" min="0" max="100" placeholder="50" value="50"
                                        id="discount_percentage" required />
                                </div>
                            </div>

                            <!-- Price Preview -->
                            <div
                                class="mt-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-700 mb-1">Prix final</p>
                                        <div class="flex items-baseline gap-2">
                                            <span id="final_price_display" class="text-3xl font-bold text-green-600">0.00
                                                MAD</span>
                                            <span id="original_price_display"
                                                class="text-sm text-gray-500 line-through"></span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-700 mb-1">Économie</p>
                                        <span id="savings_display" class="text-xl font-bold text-orange-600">0.00 MAD</span>
                                    </div>
                                </div>
                                <input type="hidden" name="price" id="price" value="0">
                            </div>
                        </div>

                        <!-- Collection Section -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Paramètres de Collecte</h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                <x-admin.date-picker name="collect_day" label="Jour de collecte" :value="now()->format('Y-m-d')" required />

                                <x-admin.date-picker name="collect_time_start" label="Heure de début" :time-only="true"  placeholder="08:00" required />

                                <x-admin.date-picker name="collect_time_end" label="Heure de fin" :time-only="true"  placeholder="08:00" required />
                                
                            </div>

                            <div class="mt-4">
                                <x-admin.textarea label="Adresse de collecte" name="collect_address"
                                    placeholder="Adresse complète de collecte" rows="3" required />
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Status Settings -->
                        <div class="admin-inset p-4">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Status</h3>
                            <x-admin.form-select label="Status" name="status" :options="$options" value="draft" required />
                        </div>

                        <!-- Enseigne & Type -->
                        <div class="admin-inset p-4">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Enseigne & Type</h3>

                            <x-admin.form-select label="Enseigne" name="enseigne" placeholder="Sélectionner une enseigne"
                                required>
                                @foreach ($enseignes ?? [] as $enseigne)
                                    <option value="{{ $enseigne->id }}" @selected(old('enseigne') == $enseigne->id)>
                                        {{ $enseigne->name }}
                                    </option>
                                @endforeach
                            </x-admin.form-select>

                            <x-admin.form-select label="Type" name="type" placeholder="Sélectionner un type"
                                required>
                                @foreach ($types ?? [] as $type)
                                    <option value="{{ $type->id }}" @selected(old('type') == $type->id)>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </x-admin.form-select>
                        </div>

                        <!-- Tags -->
                        <div class="admin-inset p-4">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Tags</h3>
                            <div
                                class="space-y-2 max-h-32 overflow-y-auto border border-slate-200/70 rounded-lg p-3 bg-white/70">
                                @foreach ($tags ?? [] as $tag)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                            @checked(in_array($tag->id, old('tags', []))) class="admin-checkbox">
                                        <span class="ml-2 text-sm text-gray-700">{{ $tag->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('tags')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Enregistrer le panier
                        </x-admin.button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const basePriceInput = document.getElementById('base_price');
            const discountInput = document.getElementById('discount_percentage');
            const priceInput = document.getElementById('price');
            const finalPriceDisplay = document.getElementById('final_price_display');
            const originalPriceDisplay = document.getElementById('original_price_display');
            const savingsDisplay = document.getElementById('savings_display');

            function calculatePrice() {
                const basePrice = parseFloat(basePriceInput.value) || 0;
                const discountPercentage = parseFloat(discountInput.value) || 0;

                // Calculate final price
                const finalPrice = basePrice * (1 - discountPercentage / 100);
                const savings = basePrice - finalPrice;

                // Update hidden input
                priceInput.value = finalPrice.toFixed(2);

                // Update displays
                finalPriceDisplay.textContent = finalPrice.toFixed(2) + ' {{ paymentSettings()->payment_currency }}';

                if (discountPercentage > 0) {
                    originalPriceDisplay.textContent = basePrice.toFixed(2) + ' {{ paymentSettings()->payment_currency }}';
                    savingsDisplay.textContent = savings.toFixed(2) + ' {{ paymentSettings()->payment_currency }}';
                } else {
                    originalPriceDisplay.textContent = '';
                    savingsDisplay.textContent = '0.00 {{ paymentSettings()->payment_currency }}';
                }
            }

            // Calculate on input change
            basePriceInput.addEventListener('input', calculatePrice);
            discountInput.addEventListener('input', calculatePrice);

            // Initial calculation
            calculatePrice();

            // Form validation
            const form = document.getElementById('panierForm');
            form.addEventListener('submit', function(e) {
                const basePrice = parseFloat(basePriceInput.value);
                const discount = parseFloat(discountInput.value);

                if (basePrice <= 0) {
                    e.preventDefault();
                    alert('Le prix de base doit être supérieur à 0');
                    basePriceInput.focus();
                    return false;
                }

                if (discount < 0 || discount > 100) {
                    e.preventDefault();
                    alert('La réduction doit être entre 0 et 100%');
                    discountInput.focus();
                    return false;
                }
            });
        });
    </script>
@endpush

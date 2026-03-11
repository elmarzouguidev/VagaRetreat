@extends('layouts.admin')

@section('title', 'Ajouter des Produits')
@section('page-title', 'Ajouter des Produits au Panier')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <x-admin.button href="{{ route('admin.paniers.show', $panier) }}" variant="outline">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour au Panier
                    </x-admin.button>
                </div>
                <div>
                    <h1 class="text-xl font-semibold text-slate-900">{{ $panier->name }}</h1>
                    <p class="text-sm text-slate-600">{{ $panier->enseigne?->name }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Available Products -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Produits Disponibles
                            </h2>
                            <span class="text-sm text-slate-600">{{ $products->count() }} produits</span>
                        </div>

                        <!-- Search -->
                        <div class="mt-4">
                            <input type="text" id="product-search" placeholder="Rechercher un produit..."
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>

                    <div class="p-6">
                        <div id="products-list" class="space-y-4 max-h-[600px] overflow-y-auto">
                            @forelse($products as $product)
                                <div class="product-item border border-slate-200 rounded-lg p-4 hover:border-blue-300 transition"
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ strtolower($product->name) }}">
                                    <div class="flex items-center gap-4">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            @if ($product->getFirstMediaUrl('products_photos', 'thumb'))
                                                <img src="{{ $product->getFirstMediaUrl('products_photos', 'thumb') }}"
                                                    alt="{{ $product->name }}" class="w-16 h-16 rounded-lg object-cover">
                                            @else
                                                <div
                                                    class="w-16 h-16 rounded-lg bg-slate-100 flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Info -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-medium text-slate-900">{{ $product->name }}</h3>
                                            <p class="text-sm text-slate-600 mt-1">Code: {{ $product->code }}</p>
                                            <div class="flex items-center gap-3 mt-2">
                                                <span class="text-sm font-semibold text-slate-900">
                                                    {{ $product->price }} MAD
                                                </span>
                                                <span class="text-xs text-slate-600">
                                                    Stock: {{ $product->quantity }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Add Button -->
                                        <div class="flex-shrink-0">
                                            <button type="button"
                                                onclick="addProduct({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->quantity }})"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                                Ajouter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <div
                                        class="w-16 h-16 bg-slate-100 rounded-full mx-auto flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <p class="text-slate-600">Aucun produit disponible pour cette enseigne.</p>
                                    <a href="{{ route('admin.products.create') }}"
                                        class="text-sm text-blue-600 hover:text-blue-800 mt-2 inline-block">
                                        Créer un nouveau produit
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Selected Products -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 sticky top-6">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Produits Sélectionnés
                        </h2>
                        <p class="text-sm text-slate-600 mt-1">
                            <span id="selected-count">0</span> produits
                        </p>
                    </div>

                    <form method="POST" action="{{ route('admin.paniers.products.store', $panier) }}" id="products-form">
                        @csrf
                        @honeypot

                        <div id="selected-products" class="p-6 space-y-3 max-h-[500px] overflow-y-auto">
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <p class="text-sm text-slate-500">Aucun produit sélectionné</p>
                            </div>
                        </div>

                        <!-- Summary -->
                        <div id="summary" class="px-6 py-4 border-t border-slate-200 bg-slate-50 hidden">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-600">Total Produits:</span>
                                    <span class="font-semibold text-slate-900" id="total-products">0</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-600">Total Quantité:</span>
                                    <span class="font-semibold text-slate-900" id="total-quantity">0</span>
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-slate-300">
                                    <span class="font-medium text-slate-900">Total Prix:</span>
                                    <span class="font-bold text-blue-600 text-lg" id="total-price">0.00 MAD</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="px-6 py-4 border-t border-slate-200">
                            <button type="submit" id="submit-btn" disabled
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Enregistrer les Produits
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        let selectedProducts = [];

        function addProduct(id, name, price, stock) {
            // Check if already added
            if (selectedProducts.find(p => p.id === id)) {
                alert('Ce produit est déjà ajouté!');
                return;
            }

            selectedProducts.push({
                id: id,
                name: name,
                price: price,
                quantity: 1,
                stock: stock
            });

            updateSelectedProducts();
        }

        function removeProduct(id) {
            selectedProducts = selectedProducts.filter(p => p.id !== id);
            updateSelectedProducts();
        }

        function updateQuantity(id, quantity) {
            const product = selectedProducts.find(p => p.id === id);
            if (product) {
                const qty = parseInt(quantity);
                if (qty > 0 && qty <= product.stock) {
                    product.quantity = qty;
                    updateSelectedProducts();
                } else if (qty > product.stock) {
                    alert(`La quantité ne peut pas dépasser le stock disponible (${product.stock})`);
                    const qtyInput = document.getElementById(`quantity-${id}`);
                    if (qtyInput) {
                        qtyInput.value = product.quantity;
                    }
                }
            }
        }

        function updatePrice(id, price) {
            const product = selectedProducts.find(p => p.id === id);
            if (product) {
                const newPrice = parseFloat(price);
                if (newPrice >= 0) {
                    product.price = newPrice;
                    updateSelectedProducts();
                }
            }
        }

        function updateSelectedProducts() {
            const container = document.getElementById('selected-products');
            const summary = document.getElementById('summary');
            const submitBtn = document.getElementById('submit-btn');
            const selectedCount = document.getElementById('selected-count');

            // Clear container first
            container.innerHTML = '';

            if (selectedProducts.length === 0) {
                // Show empty state
                container.innerHTML = `
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <p class="text-sm text-slate-500">Aucun produit sélectionné</p>
                    </div>
                `;
                summary.classList.add('hidden');
                submitBtn.disabled = true;
                selectedCount.textContent = '0';
                return;
            }

            // Show products
            summary.classList.remove('hidden');
            submitBtn.disabled = false;
            selectedCount.textContent = selectedProducts.length;

            let html = '';
            let totalPrice = 0;
            let totalQuantity = 0;

            selectedProducts.forEach(product => {
                const subtotal = product.price * product.quantity;
                totalPrice += subtotal;
                totalQuantity += product.quantity;

                html += `
                <div class="border border-slate-200 rounded-lg p-3 bg-white">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-slate-900 truncate">${escapeHtml(product.name)}</h4>
                            <p class="text-xs text-slate-600 mt-1">Stock: ${product.stock}</p>
                        </div>
                        <button type="button" 
                            onclick="removeProduct(${product.id})"
                            class="text-red-600 hover:text-red-800 p-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <input type="hidden" name="products[${product.id}][product_id]" value="${product.id}">
                    
                    <div class="space-y-2">
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Quantité</label>
                            <input type="number" 
                                id="quantity-${product.id}"
                                name="products[${product.id}][quantity]"
                                value="${product.quantity}"
                                min="1"
                                max="${product.stock}"
                                onchange="updateQuantity(${product.id}, this.value)"
                                class="w-full px-3 py-1.5 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Prix Unitaire (MAD)</label>
                            <input type="number" 
                                name="products[${product.id}][price]"
                                value="${product.price}"
                                min="0"
                                step="0.01"
                                onchange="updatePrice(${product.id}, this.value)"
                                class="w-full px-3 py-1.5 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div class="pt-2 border-t border-slate-200">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-600">Sous-total:</span>
                                <span class="font-semibold text-slate-900">${subtotal.toFixed(2)} MAD</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            });

            container.innerHTML = html;

            // Update summary
            document.getElementById('total-products').textContent = selectedProducts.length;
            document.getElementById('total-quantity').textContent = totalQuantity;
            document.getElementById('total-price').textContent = totalPrice.toFixed(2) + ' MAD';
        }

        // Helper function to escape HTML
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, m => map[m]);
        }

        // Search functionality
        document.getElementById('product-search').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const products = document.querySelectorAll('.product-item');

            products.forEach(product => {
                const productName = product.dataset.productName;
                if (productName.includes(searchTerm)) {
                    product.style.display = '';
                } else {
                    product.style.display = 'none';
                }
            });
        });

        // Form submission validation
        document.getElementById('products-form').addEventListener('submit', function(e) {
            if (selectedProducts.length === 0) {
                e.preventDefault();
                alert('Veuillez sélectionner au moins un produit!');
                return false;
            }
        });
    </script>
@endpush

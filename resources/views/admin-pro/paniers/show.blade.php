@extends('layouts.admin')

@section('title', $panier->panier_number)
@section('page-title', 'Voir le panier')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <x-admin.button href="{{ route('admin.paniers.index') }}" variant="outline">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Retour aux paniers
                    </x-admin.button>
                </div>

                <div class="flex items-center space-x-3">
                    <x-admin.button href="{{ route('admin.paniers.edit', $panier) }}" variant="primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Modifier le panier
                    </x-admin.button>

                    <form method="POST" action="{{ route('admin.paniers.delete') }}" class="inline mb-4"
                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce panier ?')">
                        @csrf
                        @method('DELETE')
                        @honeypot
                        <x-admin.form-input type="hidden" name="panier" :value="$panier->uuid" required />
                        <x-admin.button type="submit" variant="danger">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Supprimer
                        </x-admin.button>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Post Content -->
                <div class="admin-card overflow-hidden">
                    <!-- Featured Image -->
                    @if ($panier->hasFeaturedImage())
                        <div class="aspect-w-16 aspect-h-9">
                            <img src="{{ $panier->getFeaturedImageUrl() }}"
                                
                                class="w-full h-80 object-cover">
                        </div>
                    @endif

                    <div class="p-6">
                        <!-- Title and Meta -->
                        <div class="mb-6">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $panier->name }}</h1>

                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span>Par {{ $panier->user?->prenom ?? 'Unknown' }}</span>
                                <span>•</span>
                                <span>{{ $panier->created_at->format('F j, Y') }}</span>
                                @if ($panier->status->value() === \App\Enums\Panier\PanierStatusEnums::AVAILABLE->value)
                                    <span>•</span>
                                    <span>Publié {{ $panier->updated_at?->format('F j, Y') }}</span>
                                @endif
                            </div>

                            <!-- Status Badge -->
                            <div class="mt-3">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium {{ $panier->status?->color() }}">
                                    {{ $panier->status?->label() }}
                                </span>
                            </div>
                        </div>

                        <!-- Description -->
                        @if ($panier->content)
                            <div class="mb-6 p-4 bg-slate-50/70 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-900 mb-2">Description</h3>
                                <p class="text-gray-700">{{ $panier->content }}</p>
                            </div>
                        @endif

                        <!-- Body -->
                        <div class="prose max-w-none">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Body</h3>
                            <div
                                class="text-gray-700 leading-relaxed prose prose-lg max-w-none bg-slate-50/70 p-6 rounded-lg">
                                {!! $panier->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Post Details -->
                <div class="admin-card p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Détails du panier</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Numéro</label>
                            <p class="mt-1 text-sm text-gray-900 font-mono bg-slate-50/70 px-2 py-1 rounded">
                                {{ $panier->panier_number }}</p>
                        </div>
                        @if ($panier->enseigne)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Enseigne</label>
                                <p class="mt-1">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $panier->enseigne?->name }}
                                    </span>
                                </p>
                            </div>
                        @endif

                        @if ($panier->type)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Type de panier</label>
                                <p class="mt-1">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $panier->type?->name }}
                                    </span>
                                </p>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Créé</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $panier->created_at?->format('F j, Y g:i A') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dernière mise à jour</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $panier->updated_at->format('F j, Y g:i A') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">UUID</label>
                            <p class="mt-1 text-xs text-gray-500 font-mono bg-slate-50/70 px-2 py-1 rounded break-all">
                                {{ $panier->uuid }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="admin-card p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Actions rapides</h3>

                    <div class="space-y-3">
                        @if ($panier->status->value() === \App\Enums\Panier\PanierStatusEnums::DRAFT->value)
                            <form method="POST" action="{{ route('admin.paniers.update.status', $panier) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status"
                                    value="{{ \App\Enums\Panier\PanierStatusEnums::AVAILABLE->value }}">
                                <x-admin.button type="submit" variant="success" class="w-full">
                                    Publier le panier
                                </x-admin.button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.paniers.update.status', $panier) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status"
                                    value="{{ \App\Enums\Panier\PanierStatusEnums::DRAFT->value }}">
                                <x-admin.button type="submit" variant="warning" class="w-full">
                                    Désactiver le panier
                                </x-admin.button>
                            </form>
                        @endif

                        <x-admin.button href="{{ route('admin.paniers.create') }}" variant="outline" class="w-full">
                            Créer un nouveau panier
                        </x-admin.button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

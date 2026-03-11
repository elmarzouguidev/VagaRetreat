@extends('layouts.admin')

@section('title', 'Paniers')
@section('page-title', 'Paniers')

@section('content')
    <div class="space-y-6">
        <!-- Header with Create Button -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Paniers</h1>
                <p class="mt-1 text-sm text-gray-600">Organize your content with Paniers</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <x-admin.button href="{{ route('admin.paniers.create') }}" variant="primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Ajouter un panier
                </x-admin.button>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="admin-card p-6">
            <form method="GET" action="{{ route('admin.paniers.index') }}" class="flex items-end space-x-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Rechercher des paniers par nom ou par numéro..." class="admin-form-input">
                </div>

                <div class="flex space-x-2">
                    <x-admin.button type="submit" variant="outline">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Chercher
                    </x-admin.button>

                    @if (request('search'))
                        <x-admin.button href="{{ route('admin.paniers.index') }}" variant="outline">
                            Reset
                        </x-admin.button>
                    @endif
                </div>
            </form>
        </div>
        <!-- Stats Cards (Optional) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="admin-card p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Total</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="admin-card p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-emerald-100 rounded-lg">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Disponible</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $stats['available'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="admin-card p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-amber-100 rounded-lg">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Pas disponible</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $stats['notavailable'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="admin-card p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-rose-100 rounded-lg">
                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Terminé</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $stats['termined'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Paniers Table -->
        <x-admin.table :headers="['Nom', 'Prix', 'Numéro', 'Engiegne', 'Total Commands', 'Créé', 'Status', 'Actions']">
            @forelse($paniers ?? [] as $panier)
                <tr class="hover:bg-slate-50/70">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div>
                                <div class="text-sm font-medium text-gray-900">
                                    <a href="{{ route('admin.paniers.edit', $panier) }}" class="hover:text-blue-600">
                                        {{ $panier->name }}
                                    </a>
                                </div>
                                <div class="text-slate-800 font-bold text-1xl">{{ $panier->type?->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-slate-800 font-extrabold text-1xl">{{ $panier->price }} MAD</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                            {{ $panier->panier_number }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                            {{ $panier->enseigne?->name }}
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $panier->commands_count ?? 0 }} commands
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $panier->created_at?->format('M j, Y') }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium {{ $panier->status?->color() }}">
                            {{ $panier->status?->label() }}
                        </span>
                    </td>
                    <td class="px-6 py-6 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center space-x-3">
                            <x-admin.button href="{{ route('admin.paniers.show', $panier) }}" variant="outline"
                                size="sm">
                                Voir
                            </x-admin.button>
                            <x-admin.button href="{{ route('admin.paniers.edit', $panier) }}" variant="primary"
                                size="sm">
                                Modifier
                            </x-admin.button>
                            <form method="POST" action="{{ route('admin.paniers.delete') }}" class="inline mb-4"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce panier ? Cette action est irréversible.')">
                                @csrf
                                @method('DELETE')
                                @honeypot
                                <x-admin.form-input type="hidden" name="panier" :value="$panier->uuid" required />
                                <x-admin.button type="submit" variant="danger" size="sm">
                                    Supprimer
                                </x-admin.button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun panier trouvé</h3>
                            <p class="mt-1 text-sm text-gray-500">Commencez par créer un nouveau panier.</p>
                            <div class="mt-6">
                                <x-admin.button href="{{ route('admin.paniers.create') }}" variant="primary">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Créer un nouveau panier
                                </x-admin.button>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-admin.table>

        <!-- Pagination -->
        @if (isset($paniers) && $paniers->hasPages())
            <div class="admin-card px-4 py-3 border-t border-slate-200/70 sm:px-6">
                {{ $paniers->links() }}
            </div>
        @endif
    </div>
@endsection

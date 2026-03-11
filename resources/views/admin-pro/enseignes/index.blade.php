@extends('layouts.admin')

@section('title', 'Enseignes')
@section('page-title', 'Enseignes')

@section('content')
    <div class="space-y-6">
        <!-- Header with Create Button -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Gestion des Enseignes</h1>
                <p class="mt-1 text-sm text-slate-600">Gérez tous vos enseignes en un seul endroit</p>
            </div>
            <div class="flex-shrink-0">
                <x-admin.button href="{{ route('admin.enseignes.create') }}" variant="primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouveau Enseigne
                </x-admin.button>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <form method="GET" action="{{ route('admin.enseignes.index') }}"
                class="space-y-4 sm:space-y-0 sm:flex sm:items-end sm:gap-4">

                <!-- Search Input -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-slate-700 mb-2">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Rechercher
                    </label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Rechercher par nom, code ou description..."
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>

                @hasrole(\App\Enums\Roles\RolesEnums::SUPERADMIN)
                    <!-- user Filter -->
                    <div class="sm:w-56">
                        <label for="user" class="block text-sm font-medium text-slate-700 mb-2">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Professionel
                        </label>
                        <select id="user" name="user"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">Toutes les professionels</option>
                            @foreach ($users ?? [] as $user)
                                <option value="{{ $user->id }}" @selected(request('user') == $user->id)>
                                    {{ $user->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endhasrole
                <!-- Status Filter -->
                <div class="sm:w-44">
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Statut
                    </label>
                    <select id="status" name="status"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">Tous les statuts</option>
                        @foreach ($statuses as $statusOption)
                            <option value="{{ $statusOption->value }}" @selected(request('status') == $statusOption->value)>
                                {{ $statusOption->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <x-admin.button type="submit" variant="primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Rechercher
                    </x-admin.button>

                    @if (request()->hasAny(['search', 'user', 'status']))
                        <x-admin.button href="{{ route('admin.enseignes.index') }}" variant="outline">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Réinitialiser
                        </x-admin.button>
                    @endif
                </div>
            </form>
        </div>

        <!-- Products Table -->
        <x-admin.table :headers="['Enseigne', 'Professionel', 'CODE', 'Telephone', 'E-mail', 'Site web', 'Créé', 'Status', 'Actions']">
            @forelse($enseignes ?? [] as $enseigne)
                <tr class="hover:bg-slate-50/70">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div>
                                <div class="text-sm font-medium text-gray-900">
                                    <a href="{{ route('admin.enseignes.edit', $enseigne) }}" class="hover:text-blue-600">
                                        {{ $enseigne->name }}
                                    </a>
                                </div>
                                <div class="text-slate-800 font-bold text-1xl">{{ $enseigne->enseigneType?->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-slate-800 font-extrabold text-1xl">{{ $enseigne->user?->full_name }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                            {{ $enseigne->code }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                            {{ $enseigne->telephone }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                            {{ $enseigne->email }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                            {{ $enseigne->website ?? 'N/A' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $enseigne->created_at?->format('M j, Y') }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium {{ $enseigne->status?->badgeClasses() }}">
                            {{ $enseigne->status?->label() }}
                        </span>
                    </td>
                    <td class="px-6 py-6 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center space-x-3">
                            <x-admin.button href="{{ route('admin.enseignes.show', $enseigne) }}" variant="outline"
                                size="sm">
                                Voir
                            </x-admin.button>
                            <x-admin.button href="{{ route('admin.enseignes.edit', $enseigne) }}" variant="primary"
                                size="sm">
                                Modifier
                            </x-admin.button>
                            <form method="POST" action="{{ route('admin.enseignes.delete') }}" class="inline mb-4"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce enseigne? Cette action est irréversible.')">
                                @csrf
                                @method('DELETE')
                                @honeypot
                                <x-admin.form-input type="hidden" name="enseigne" :value="$enseigne->uuid" required />
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
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun enseigne trouvé</h3>
                            <p class="mt-1 text-sm text-gray-500">Commencez par créer un nouveau enseigne.</p>
                            <div class="mt-6">
                                <x-admin.button href="{{ route('admin.enseignes.create') }}" variant="primary">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Créer un nouveau enseigne
                                </x-admin.button>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-admin.table>

        <!-- Pagination -->
        @if (isset($enseignes) && $enseignes->hasPages())
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 px-4 py-3">
                {{ $enseignes->links() }}
            </div>
        @endif
    </div>
@endsection

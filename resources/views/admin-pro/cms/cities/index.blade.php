@extends('layouts.admin')

@section('title', 'Villes')
@section('page-title', 'Villes')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Référentiels</p>
                    <h1 class="mt-2 text-2xl font-semibold text-slate-900">Villes</h1>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Référentiel géographique utilisé dans l’application.</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-600">
                        Total: <span class="font-semibold text-slate-900">{{ $cities->total() }}</span>
                    </div>
                    <x-admin.button href="{{ route('admin.cms.cities.create') }}" variant="primary">Ajouter une ville</x-admin.button>
                </div>
            </div>

            <div class="px-6 py-5">
                <form method="GET" class="grid gap-4 lg:grid-cols-[1fr_auto]">
                    <div>
                        <x-admin.form-input label="Recherche" name="search" :value="$search" placeholder="Nom, code ou slug..." />
                    </div>
                    <div class="flex items-end gap-2">
                        <x-admin.button type="submit" variant="outline">Filtrer</x-admin.button>
                        @if ($search)
                            <x-admin.button href="{{ route('admin.cms.cities.index') }}" variant="outline">Réinitialiser</x-admin.button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <x-admin.table :headers="['Ville', 'Pays', 'Utilisation', 'Statut', 'Actions']">
                @forelse ($cities as $city)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">{{ $city->name }}</div>
                            <div class="text-xs text-slate-500">{{ $city->slug }}{{ $city->code ? ' • '.$city->code : '' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $city->country?->name ?? 'Non défini' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $city->users_count }} utilisateurs • {{ $city->enseignes_count }} enseignes • {{ $city->paniers_count }} paniers
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $city->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ $city->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <x-admin.button href="{{ route('admin.cms.cities.edit', $city) }}" variant="outline" size="sm">Modifier</x-admin.button>
                                <form method="POST" action="{{ route('admin.cms.cities.destroy', $city) }}" onsubmit="return confirm('Supprimer cette ville ?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-admin.button type="submit" variant="danger" size="sm">Supprimer</x-admin.button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">Aucune ville trouvée.</td>
                    </tr>
                @endforelse
            </x-admin.table>
        </div>

        {{ $cities->links() }}
    </div>
@endsection

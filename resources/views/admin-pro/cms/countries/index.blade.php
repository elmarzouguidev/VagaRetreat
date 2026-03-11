@extends('layouts.admin')

@section('title', 'Pays')
@section('page-title', 'Pays')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Référentiels</p>
                    <h1 class="mt-2 text-2xl font-semibold text-slate-900">Pays</h1>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Référentiel des pays utilisés par les villes et les banques.</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-600">
                        Total: <span class="font-semibold text-slate-900">{{ $countries->total() }}</span>
                    </div>
                    <x-admin.button href="{{ route('admin.cms.countries.create') }}" variant="primary">Ajouter un pays</x-admin.button>
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
                            <x-admin.button href="{{ route('admin.cms.countries.index') }}" variant="outline">Réinitialiser</x-admin.button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <x-admin.table :headers="['Pays', 'Code', 'Villes', 'Statut', 'Actions']">
                @forelse ($countries as $country)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">{{ $country->name }}</div>
                            <div class="text-xs text-slate-500">{{ $country->slug }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $country->code }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $country->cities_count }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $country->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ $country->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <x-admin.button href="{{ route('admin.cms.countries.edit', $country) }}" variant="outline" size="sm">Modifier</x-admin.button>
                                <form method="POST" action="{{ route('admin.cms.countries.destroy', $country) }}" onsubmit="return confirm('Supprimer ce pays ?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-admin.button type="submit" variant="danger" size="sm">Supprimer</x-admin.button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">Aucun pays trouvé.</td>
                    </tr>
                @endforelse
            </x-admin.table>
        </div>

        {{ $countries->links() }}
    </div>
@endsection

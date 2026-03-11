@extends('layouts.admin')

@section('title', 'Marques')
@section('page-title', 'Marques')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Catalogue</p>
                    <h1 class="mt-2 text-2xl font-semibold text-slate-900">Marques</h1>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Gérez les marques associées aux enseignes.</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-600">
                        Total: <span class="font-semibold text-slate-900">{{ $brands->total() }}</span>
                    </div>
                    <x-admin.button href="{{ route('admin.cms.brands.create') }}" variant="primary">Ajouter une marque</x-admin.button>
                </div>
            </div>

            <div class="px-6 py-5">
                <form method="GET" class="grid gap-4 lg:grid-cols-[1fr_auto]">
                    <div>
                        <x-admin.form-input label="Recherche" name="search" :value="$search" placeholder="Nom ou slug..." />
                    </div>
                    <div class="flex items-end gap-2">
                        <x-admin.button type="submit" variant="outline">Filtrer</x-admin.button>
                        @if ($search)
                            <x-admin.button href="{{ route('admin.cms.brands.index') }}" variant="outline">Réinitialiser</x-admin.button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <x-admin.table :headers="['Marque', 'Logo', 'Enseignes', 'Statut', 'Actions']">
                @forelse ($brands as $brand)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">{{ $brand->name }}</div>
                            <div class="text-xs text-slate-500">{{ $brand->slug ?: 'Aucun slug' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if ($brand->getFirstMediaUrl('brands_logos'))
                                <img src="{{ $brand->getFirstMediaUrl('brands_logos') }}" alt="{{ $brand->name }}" class="h-12 w-20 rounded-lg border border-slate-200 object-cover">
                            @else
                                <span class="text-xs text-slate-400">Aucun logo</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $brand->enseignes_count }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $brand->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ $brand->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <x-admin.button href="{{ route('admin.cms.brands.edit', $brand) }}" variant="outline" size="sm">Modifier</x-admin.button>
                                <form method="POST" action="{{ route('admin.cms.brands.destroy', $brand) }}" onsubmit="return confirm('Supprimer cette marque ?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-admin.button type="submit" variant="danger" size="sm">Supprimer</x-admin.button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">Aucune marque trouvée.</td>
                    </tr>
                @endforelse
            </x-admin.table>
        </div>

        {{ $brands->links() }}
    </div>
@endsection

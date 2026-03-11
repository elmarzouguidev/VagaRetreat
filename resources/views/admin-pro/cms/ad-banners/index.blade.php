@extends('layouts.admin')

@section('title', 'Bannières publicitaires')
@section('page-title', 'Bannières publicitaires')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Marketing</p>
                    <h1 class="mt-2 text-2xl font-semibold text-slate-900">Bannières publicitaires</h1>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Gérez les bannières affichées sur l’accueil de l’application mobile.</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-600">
                        Total: <span class="font-semibold text-slate-900">{{ $banners->total() }}</span>
                    </div>
                    <x-admin.button href="{{ route('admin.cms.ad-banners.create') }}" variant="primary">Ajouter une bannière</x-admin.button>
                </div>
            </div>

            <div class="px-6 py-5">
                <form method="GET" class="grid gap-4 lg:grid-cols-[1fr_auto]">
                    <div>
                        <x-admin.form-input label="Recherche" name="search" :value="$search" placeholder="Titre ou contenu..." />
                    </div>
                    <div class="flex items-end gap-2">
                        <x-admin.button type="submit" variant="outline">Filtrer</x-admin.button>
                        @if ($search)
                            <x-admin.button href="{{ route('admin.cms.ad-banners.index') }}" variant="outline">Réinitialiser</x-admin.button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <x-admin.table :headers="['Bannière', 'Ciblage', 'Vues', 'Statut', 'Actions']">
                @forelse ($banners as $banner)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                @if ($banner->getFirstMediaUrl('ad_banners_cover'))
                                    <img src="{{ $banner->getFirstMediaUrl('ad_banners_cover') }}" alt="{{ $banner->title ?: 'Banner' }}" class="h-14 w-24 rounded-lg border border-slate-200 object-cover">
                                @else
                                    <div class="flex h-14 w-24 items-center justify-center rounded-lg border border-dashed border-slate-300 text-xs text-slate-400">
                                        Sans image
                                    </div>
                                @endif
                                <div>
                                    <div class="font-medium text-slate-900">{{ $banner->title ?: 'Sans titre' }}</div>
                                    <div class="text-xs text-slate-500">{{ \Illuminate\Support\Str::limit(strip_tags((string) $banner->content), 70) ?: 'Aucune description' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            <div>{{ $banner->city?->name ?? 'Toutes les villes' }}</div>
                            <div class="text-xs text-slate-500">
                                {{ $banner->enseigne?->name ?? 'Toutes les enseignes' }}
                                @if ($banner->user)
                                    • {{ trim($banner->user->nom . ' ' . $banner->user->prenom) }}
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ number_format($banner->views) }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $banner->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ $banner->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <x-admin.button href="{{ route('admin.cms.ad-banners.edit', $banner) }}" variant="outline" size="sm">Modifier</x-admin.button>
                                <form method="POST" action="{{ route('admin.cms.ad-banners.destroy', $banner) }}" onsubmit="return confirm('Supprimer cette bannière publicitaire ?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-admin.button type="submit" variant="danger" size="sm">Supprimer</x-admin.button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">Aucune bannière trouvée.</td>
                    </tr>
                @endforelse
            </x-admin.table>
        </div>

        {{ $banners->links() }}
    </div>
@endsection

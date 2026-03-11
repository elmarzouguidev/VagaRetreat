@extends('layouts.admin')

@section('title', 'Méthodes de paiement')
@section('page-title', 'Méthodes de paiement')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Paiement</p>
                    <h1 class="mt-2 text-2xl font-semibold text-slate-900">Méthodes de paiement</h1>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Gérez les modes de paiement disponibles dans l’écosystème Save Me.</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-600">
                        Total: <span class="font-semibold text-slate-900">{{ $paymentMethods->total() }}</span>
                    </div>
                    <x-admin.button href="{{ route('admin.cms.payment-methods.create') }}" variant="primary">Ajouter une méthode</x-admin.button>
                </div>
            </div>

            <div class="px-6 py-5">
                <form method="GET" class="grid gap-4 lg:grid-cols-[1fr_auto]">
                    <div>
                        <x-admin.form-input label="Recherche" name="search" :value="$search" placeholder="Nom..." />
                    </div>
                    <div class="flex items-end gap-2">
                        <x-admin.button type="submit" variant="outline">Filtrer</x-admin.button>
                        @if ($search)
                            <x-admin.button href="{{ route('admin.cms.payment-methods.index') }}" variant="outline">Réinitialiser</x-admin.button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <x-admin.table :headers="['Méthode', 'Devise', 'Transactions', 'Statut', 'Actions']">
                @forelse ($paymentMethods as $paymentMethod)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">{{ $paymentMethod->name }}</div>
                            <div class="text-xs text-slate-500">{{ \Illuminate\Support\Str::limit(strip_tags((string) $paymentMethod->content), 70) ?: 'Aucune description' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $paymentMethod->default_currency?->value ?? $paymentMethod->default_currency }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $paymentMethod->transactions_count }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $paymentMethod->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ $paymentMethod->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <x-admin.button href="{{ route('admin.cms.payment-methods.edit', $paymentMethod) }}" variant="outline" size="sm">Modifier</x-admin.button>
                                <form method="POST" action="{{ route('admin.cms.payment-methods.destroy', $paymentMethod) }}" onsubmit="return confirm('Supprimer cette méthode de paiement ?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-admin.button type="submit" variant="danger" size="sm">Supprimer</x-admin.button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">Aucune méthode de paiement trouvée.</td>
                    </tr>
                @endforelse
            </x-admin.table>
        </div>

        {{ $paymentMethods->links() }}
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'Paiements Professionnels')
@section('page-title', 'Paiements Professionnels')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Préparation mensuelle des virements</h2>
                        <p class="mt-1 text-sm text-slate-600">Ce module ne traite pas le paiement Stripe. Il prépare uniquement le montant à transférer aux professionnels validés.</p>
                    </div>

                    <form method="GET" action="{{ route('admin.payouts.index') }}" class="flex flex-wrap items-end gap-3">
                        <div>
                            <label for="month" class="mb-1 block text-sm font-medium text-slate-700">Mois</label>
                            <input id="month" name="month" type="number" min="1" max="12" value="{{ $month }}"
                                class="w-24 rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>

                        <div>
                            <label for="year" class="mb-1 block text-sm font-medium text-slate-700">Année</label>
                            <input id="year" name="year" type="number" min="2024" value="{{ $year }}"
                                class="w-28 rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>

                        <x-admin.button type="submit" variant="outline">Actualiser</x-admin.button>
                    </form>
                </div>
            </div>

            <div class="grid gap-4 p-6 md:grid-cols-4">
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-sm font-medium text-slate-500">Période</p>
                    <p class="mt-2 text-lg font-semibold text-slate-900">{{ $preview['period']['label'] }}</p>
                </div>
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4">
                    <p class="text-sm font-medium text-slate-500">Professionnels éligibles</p>
                    <p class="mt-2 text-lg font-semibold text-emerald-700">{{ number_format($preview['totals']['professionals']) }}</p>
                </div>
                <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">
                    <p class="text-sm font-medium text-slate-500">Professionnels bloqués</p>
                    <p class="mt-2 text-lg font-semibold text-amber-700">{{ number_format($preview['totals']['blocked_professionals']) }}</p>
                </div>
                <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                    <p class="text-sm font-medium text-slate-500">Montant à transférer</p>
                    <p class="mt-2 text-lg font-semibold text-blue-700">{{ number_format($preview['totals']['payout_amount'] / 100, 2) }} {{ paymentSettings()->payment_currency }}</p>
                </div>
            </div>

            <div class="border-t border-slate-200 px-6 py-4">
                @if ($preview['existing_run'])
                    <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        Un lot existe déjà pour cette période : généré le {{ $preview['existing_run']->generated_at?->format('d/m/Y H:i') }}.
                    </div>
                @else
                    <form method="POST" action="{{ route('admin.payouts.generate') }}" class="flex flex-wrap items-center gap-3">
                        @csrf
                        <input type="hidden" name="year" value="{{ $year }}">
                        <input type="hidden" name="month" value="{{ $month }}">
                        <x-admin.button type="submit" variant="primary">
                            Générer le lot de paiement
                        </x-admin.button>
                    </form>
                @endif
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h3 class="text-base font-semibold text-slate-900">Professionnels éligibles</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Professionnel</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Transactions</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">À transférer</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse ($preview['eligible'] as $item)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-slate-900">
                                        <div class="font-medium">{{ $item['professional']->full_name }}</div>
                                        <div class="text-slate-500">{{ $item['professional']->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-700">{{ number_format($item['transactions_count']) }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                                        {{ number_format($item['payout_amount'] / 100, 2) }} {{ paymentSettings()->payment_currency }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-10 text-center text-sm text-slate-500">
                                        Aucun professionnel éligible pour cette période.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h3 class="text-base font-semibold text-slate-900">Professionnels bloqués</h3>
                </div>

                <div class="space-y-4 p-6">
                    @forelse ($preview['blocked'] as $item)
                        <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-4">
                            <p class="text-sm font-semibold text-slate-900">{{ $item['professional']->full_name }}</p>
                            <p class="mt-1 text-sm text-slate-600">{{ $item['professional']->email }}</p>
                            <ul class="mt-3 space-y-1 text-sm text-amber-800">
                                @foreach ($item['blocking_reasons'] as $reason)
                                    <li>- {{ $reason }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Aucun blocage détecté pour cette période.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h3 class="text-base font-semibold text-slate-900">Historique des lots générés</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Période</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Professionnels</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Généré le</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($runs as $run)
                            <tr>
                                <td class="px-6 py-4 text-sm text-slate-900">{{ $run->periodLabel() }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ number_format($run->total_professionals) }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                                    {{ number_format($run->total_payout_amount / 100, 2) }} {{ paymentSettings()->payment_currency }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $run->generated_at?->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-sm text-slate-500">
                                    Aucun lot de paiement généré pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($runs->hasPages())
                <div class="border-t border-slate-200 px-6 py-4">
                    {{ $runs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

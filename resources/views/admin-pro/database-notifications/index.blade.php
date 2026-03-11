@extends('layouts.admin')

@section('title', 'Notifications Base de Données')
@section('page-title', 'Notifications Base de Données')

@php
    $selectedType = request('type');
    $selectedStatus = request('status');
    $selectedUserId = request('user_id');
@endphp

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total</p>
                <p class="mt-2 text-2xl font-semibold text-slate-900">{{ number_format($stats['total']) }}</p>
            </div>

            <div class="rounded-lg border border-amber-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Non lues</p>
                <p class="mt-2 text-2xl font-semibold text-amber-700">{{ number_format($stats['unread']) }}</p>
            </div>

            <div class="rounded-lg border border-emerald-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Lues</p>
                <p class="mt-2 text-2xl font-semibold text-emerald-700">{{ number_format($stats['read']) }}</p>
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Historique des notifications</h2>
                        <p class="mt-1 text-sm text-slate-600">Consultez toutes les notifications stockées en base, puis marquez-les comme lues si nécessaire.</p>
                    </div>

                    <form method="POST" action="{{ route('admin.database-notifications.mark-all-read') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $selectedUserId }}">
                        <input type="hidden" name="status" value="{{ $selectedStatus }}">
                        <input type="hidden" name="type" value="{{ $selectedType }}">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <x-admin.button type="submit" variant="outline">
                            Marquer la sélection comme lue
                        </x-admin.button>
                    </form>
                </div>
            </div>

            <div class="border-b border-slate-200 px-6 py-4">
                <form method="GET" action="{{ route('admin.database-notifications.index') }}"
                    class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                    <div class="xl:col-span-2">
                        <label for="search" class="mb-1 block text-sm font-medium text-slate-700">Recherche</label>
                        <input id="search" name="search" type="text" value="{{ request('search') }}"
                            placeholder="Titre, contenu, type..."
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>

                    <div>
                        <label for="user_id" class="mb-1 block text-sm font-medium text-slate-700">Utilisateur</label>
                        <select id="user_id" name="user_id"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                            <option value="">Tous</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected((string) $selectedUserId === (string) $user->id)>
                                    {{ $user->full_name }} - {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="status" class="mb-1 block text-sm font-medium text-slate-700">Statut</label>
                        <select id="status" name="status"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                            <option value="">Tous</option>
                            <option value="unread" @selected($selectedStatus === 'unread')>Non lues</option>
                            <option value="read" @selected($selectedStatus === 'read')>Lues</option>
                        </select>
                    </div>

                    <div>
                        <label for="type" class="mb-1 block text-sm font-medium text-slate-700">Type complet</label>
                        <input id="type" name="type" type="text" value="{{ $selectedType }}"
                            placeholder="App\\Notifications\\..."
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>

                    <div class="md:col-span-2 xl:col-span-5 flex flex-wrap gap-3">
                        <x-admin.button type="submit" variant="primary">Filtrer</x-admin.button>
                        <x-admin.button href="{{ route('admin.database-notifications.index') }}" variant="outline">Réinitialiser</x-admin.button>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Notification</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Utilisateur</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Date</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($notifications as $notification)
                            @php
                                $title = data_get($notification->data, 'title', 'Sans titre');
                                $body = data_get($notification->data, 'body', 'Aucun contenu');
                                $recipient = $notification->notifiable;
                            @endphp
                            <tr class="align-top">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-slate-900">{{ $title }}</p>
                                    <p class="mt-1 line-clamp-2 text-sm text-slate-600">{{ $body }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    @if ($recipient instanceof \App\Models\User)
                                        <div class="font-medium text-slate-900">{{ $recipient->full_name }}</div>
                                        <div class="text-slate-500">{{ $recipient->email }}</div>
                                    @else
                                        <span class="text-slate-500">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 break-all">{{ class_basename($notification->type) }}</td>
                                <td class="px-6 py-4">
                                    @if ($notification->read_at)
                                        <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-700">Lue</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-xs font-medium text-amber-700">Non lue</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $notification->created_at?->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <x-admin.button href="{{ route('admin.database-notifications.show', $notification) }}" variant="outline">
                                            Voir
                                        </x-admin.button>

                                        @if (is_null($notification->read_at))
                                            <form method="POST"
                                                action="{{ route('admin.database-notifications.mark-read', $notification) }}">
                                                @csrf
                                                <x-admin.button type="submit" variant="outline">
                                                    Lire
                                                </x-admin.button>
                                            </form>
                                        @endif

                                        <form method="POST"
                                            action="{{ route('admin.database-notifications.destroy', $notification) }}"
                                            onsubmit="return confirm('Supprimer cette notification ?');">
                                            @csrf
                                            @method('DELETE')
                                            <x-admin.button type="submit" variant="danger">
                                                Supprimer
                                            </x-admin.button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">
                                    Aucune notification trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($notifications->hasPages())
                <div class="border-t border-slate-200 px-6 py-4">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

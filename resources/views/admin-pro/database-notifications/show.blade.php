@extends('layouts.admin')

@section('title', 'Détail de la notification')
@section('page-title', 'Détail de la notification')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">
        <div class="flex items-center justify-between gap-4">
            <x-admin.button href="{{ route('admin.database-notifications.index') }}" variant="outline">
                Retour à la liste
            </x-admin.button>

            <div class="flex gap-2">
                @if (is_null($notification->read_at))
                    <form method="POST" action="{{ route('admin.database-notifications.mark-read', $notification) }}">
                        @csrf
                        <x-admin.button type="submit" variant="outline">
                            Marquer comme lue
                        </x-admin.button>
                    </form>
                @endif

                <form method="POST" action="{{ route('admin.database-notifications.destroy', $notification) }}"
                    onsubmit="return confirm('Supprimer cette notification ?');">
                    @csrf
                    @method('DELETE')
                    <x-admin.button type="submit" variant="danger">
                        Supprimer
                    </x-admin.button>
                </form>
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-900">{{ data_get($notification->data, 'title', 'Sans titre') }}</h2>
            </div>

            <div class="grid gap-6 p-6 lg:grid-cols-3">
                <div class="lg:col-span-1">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-slate-500">Statut</dt>
                            <dd class="mt-2">
                                @if ($notification->read_at)
                                    <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-700">Lue</span>
                                @else
                                    <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-xs font-medium text-amber-700">Non lue</span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-500">Type</dt>
                            <dd class="mt-2 break-all text-sm text-slate-900">{{ $notification->type }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-500">Destinataire</dt>
                            <dd class="mt-2 text-sm text-slate-900">
                                @if ($notification->notifiable instanceof \App\Models\User)
                                    {{ $notification->notifiable->full_name }}<br>
                                    <span class="text-slate-500">{{ $notification->notifiable->email }}</span>
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-500">Créée le</dt>
                            <dd class="mt-2 text-sm text-slate-900">{{ $notification->created_at?->format('d/m/Y H:i') }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-slate-500">Lue le</dt>
                            <dd class="mt-2 text-sm text-slate-900">
                                {{ $notification->read_at?->format('d/m/Y H:i') ?? 'Pas encore' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                        <h3 class="text-sm font-semibold text-slate-900">Message</h3>
                        <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-700">
                            {{ data_get($notification->data, 'body', 'Aucun contenu') }}
                        </p>
                    </div>

                    <div class="rounded-lg border border-slate-200 bg-white">
                        <div class="border-b border-slate-200 px-4 py-3">
                            <h3 class="text-sm font-semibold text-slate-900">Payload JSON</h3>
                        </div>

                        <div class="p-4">
                            <pre class="max-h-[32rem] overflow-auto rounded-lg bg-slate-950 p-4 text-xs leading-6 text-slate-100">{{ json_encode($notification->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

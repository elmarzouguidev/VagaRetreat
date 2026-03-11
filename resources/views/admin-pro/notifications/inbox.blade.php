@extends('layouts.admin')
@section('title', 'Inbox Notifications')
@section('page-title', 'Notifications Inbox')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Inbox par utilisateur</h2>
                <p class="text-sm text-slate-600 mt-1">Consultez les notifications stockées en base de données.</p>
            </div>

            <a href="{{ route('admin.notifications.index') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition text-sm font-medium">
                Envoyer une notification
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="bg-white border border-slate-200 rounded-xl p-4 lg:col-span-1">
                <form method="GET" action="{{ route('admin.notifications.inbox') }}" class="space-y-3">
                    <label for="user_id" class="block text-sm font-medium text-slate-700">Utilisateur</label>
                    @if ($users->isNotEmpty())
                        <select id="user_id" name="user_id"
                            class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            onchange="this.form.submit()">
                            @foreach ($users as $user)
                                <option value="{{ $user->uuid }}" @selected(($selectedUser?->uuid ?? null) === $user->uuid)>
                                    {{ $user->full_name }} - {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <p class="text-sm text-slate-500">Aucun utilisateur client trouvé.</p>
                    @endif
                </form>

                @if (($selectedUser?->id ?? null))
                    <div class="mt-4 rounded-lg bg-blue-50 border border-blue-100 p-3">
                        <p class="text-xs uppercase tracking-wide text-blue-700 font-semibold">Non lues</p>
                        <p class="text-2xl font-bold text-blue-900 mt-1">{{ $unreadCount }}</p>
                    </div>

                    <form method="POST"
                        action="{{ route('admin.notifications.inbox.mark-all-read', ['user' => $selectedUser->id]) }}"
                        class="mt-4">
                        @csrf
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                            Tout marquer lu
                        </button>
                    </form>
                @endif
            </div>

            <div class="bg-white border border-slate-200 rounded-xl lg:col-span-3">
                <div class="px-5 py-4 border-b border-slate-200">
                    <h3 class="text-sm font-semibold text-slate-900">
                        @if (($selectedUser?->id ?? null))
                            Notifications de {{ $selectedUser->full_name }}
                        @else
                            Aucune notification
                        @endif
                    </h3>
                </div>

                <div class="divide-y divide-slate-100">
                    @if (($selectedUser?->id ?? null) && $notifications->count())
                        @foreach ($notifications as $notification)
                            <div class="p-5">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $notification->read_at ? 'bg-slate-100 text-slate-700' : 'bg-amber-100 text-amber-800' }}">
                                                {{ $notification->read_at ? 'Lue' : 'Non lue' }}
                                            </span>
                                            <span class="text-xs text-slate-500">
                                                {{ $notification->created_at?->format('Y-m-d H:i:s') }}
                                            </span>
                                        </div>

                                        <h4 class="text-sm font-semibold text-slate-900">
                                            {{ $notification->data['title'] ?? 'Notification' }}
                                        </h4>

                                        <p class="text-sm text-slate-700">
                                            {{ $notification->data['body'] ?? '-' }}
                                        </p>

                                        @php
                                            $payloadData = $notification->data['payload'] ?? ($notification->data['data'] ?? null);
                                        @endphp
                                        @if (!empty($payloadData))
                                            <details class="mt-2">
                                                <summary class="cursor-pointer text-xs text-blue-700 font-medium">Voir payload
                                                </summary>
                                                <pre
                                                    class="mt-2 text-xs bg-slate-900 text-slate-100 rounded-lg p-3 overflow-x-auto">{{ json_encode($payloadData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                            </details>
                                        @endif
                                    </div>

                                    @if (!$notification->read_at)
                                        <form method="POST"
                                            action="{{ route('admin.notifications.inbox.mark-read', ['user' => $selectedUser->id, 'notification' => $notification->id]) }}">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition">
                                                Marquer lu
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="p-8 text-center text-slate-500 text-sm">
                            Aucune notification trouvée.
                        </div>
                    @endif
                </div>

                @if (($selectedUser?->id ?? null) && method_exists($notifications, 'links'))
                    <div class="px-5 py-4 border-t border-slate-200">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

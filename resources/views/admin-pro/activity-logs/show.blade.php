@extends('layouts.admin')

@section('title', 'Détails de l\'Activité')
@section('page-title', 'Détails de l\'Activité')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <x-admin.button href="{{ route('admin.activity-logs.index') }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour aux Logs
            </x-admin.button>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-slate-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full {{ $activityLog->color }} flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $activityLog->icon }}" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-lg font-semibold text-slate-900">{{ $activityLog->description }}</h2>
                        <p class="text-sm text-slate-600 mt-1">
                            {{ $activityLog->created_at->format('d/m/Y à H:i:s') }}
                            ({{ $activityLog->created_at->diffForHumans() }})
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Basic Information -->
                <div>
                    <h3 class="text-sm font-semibold text-slate-900 mb-4">Informations de Base</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Type d'Événement</dt>
                            <dd class="text-sm text-slate-900">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $activityLog->color }}">
                                    {{ ucfirst($activityLog->event ?? 'N/A') }}
                                </span>
                            </dd>
                        </div>

                        @if ($activityLog->log_name)
                            <div>
                                <dt class="text-sm font-medium text-slate-700 mb-1">Module</dt>
                                <dd class="text-sm text-slate-900 font-semibold">{{ ucfirst($activityLog->log_name) }}</dd>
                            </div>
                        @endif

                        @if ($activityLog->causer)
                            <div>
                                <dt class="text-sm font-medium text-slate-700 mb-1">Utilisateur</dt>
                                <dd class="text-sm text-slate-900 font-semibold">{{ $activityLog->causer?->full_name }}</dd>
                            </div>
                        @endif

                        @if ($activityLog->ip_address)
                            <div>
                                <dt class="text-sm font-medium text-slate-700 mb-1">Adresse IP</dt>
                                <dd class="text-sm text-slate-900 font-mono">{{ $activityLog->ip_address }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- User Agent -->
                @if ($activityLog->user_agent)
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900 mb-2">Informations du Navigateur</h3>
                        <p class="text-sm text-slate-600 font-mono bg-slate-50 p-3 rounded-lg border border-slate-200">
                            {{ $activityLog->user_agent }}
                        </p>
                    </div>
                @endif

                <!-- Subject Information -->
                @if ($activityLog->subject)
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900 mb-4">Objet de l'Activité</h3>
                        <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-slate-700 mb-1">Type</dt>
                                    <dd class="text-sm text-slate-900 font-semibold">
                                        {{ class_basename($activityLog->subject_type) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-slate-700 mb-1">ID</dt>
                                    <dd class="text-sm text-slate-900 font-mono">{{ $activityLog->subject_id }}</dd>
                                </div>
                                @if (method_exists($activityLog->subject, 'getRouteKey'))
                                    <div class="md:col-span-2">
                                        <dt class="text-sm font-medium text-slate-700 mb-1">Lien</dt>
                                        <dd>
                                            @php
                                                $routeName = null;
                                                $model = class_basename($activityLog->subject_type);

                                                if ($model === 'Enseigne') {
                                                    $routeName = 'admin.enseignes.show';
                                                } elseif ($model === 'Panier') {
                                                    $routeName = 'admin.paniers.show';
                                                } elseif ($model === 'Product') {
                                                    $routeName = 'admin.products.show';
                                                } elseif ($model === 'Command') {
                                                    $routeName = 'admin.orders.show';
                                                } elseif ($model === 'Transaction') {
                                                    $routeName = 'admin.transactions.show';
                                                } elseif ($model === 'User') {
                                                    $routeName = 'admin.users.show';
                                                }
                                            @endphp

                                            @if ($routeName && Route::has($routeName))
                                                <a href="{{ route($routeName, $activityLog->subject) }}"
                                                    class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800">
                                                    Voir {{ $model }}
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                    </svg>
                                                </a>
                                            @else
                                                <span class="text-sm text-slate-500">Lien non disponible</span>
                                            @endif
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                @endif

                <!-- Changes (for update events) -->
                @if ($activityLog->event === 'updated' && !empty($activityLog->changes))
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900 mb-4">Modifications Effectuées</h3>
                        <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">
                                                Champ</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">
                                                Ancienne Valeur</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">
                                                Nouvelle Valeur</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200">
                                        @foreach ($activityLog->changes as $key => $newValue)
                                            <tr>
                                                <td class="px-4 py-3 text-sm font-medium text-slate-900">
                                                    {{ ucfirst(str_replace('_', ' ', $key)) }}
                                                </td>
                                                <td class="px-4 py-3 text-sm">
                                                    @if (isset($activityLog->old_values[$key]))
                                                        <span
                                                            class="inline-block px-2 py-1 bg-red-100 text-red-800 rounded">
                                                            {{ $activityLog->old_values[$key] }}
                                                        </span>
                                                    @else
                                                        <span class="text-slate-400">—</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-sm">
                                                    <span
                                                        class="inline-block px-2 py-1 bg-green-100 text-green-800 rounded">
                                                        {{ $newValue }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- All Properties (for created events) -->
                @if ($activityLog->event === 'created' && !empty($activityLog->properties['attributes']))
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900 mb-4">Données Créées</h3>
                        <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                            <pre class="text-xs text-slate-700 overflow-x-auto">{{ json_encode($activityLog->properties['attributes'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>
                @endif

                <!-- Additional Properties -->
                @if (
                    !empty($activityLog->properties) &&
                        !isset($activityLog->properties['attributes']) &&
                        !isset($activityLog->properties['old']))
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900 mb-4">Données Supplémentaires</h3>
                        <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                            <pre class="text-xs text-slate-700 overflow-x-auto">{{ json_encode($activityLog->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
                    <form method="POST" action="{{ route('admin.activity-logs.destroy', $activityLog) }}"
                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce log ?')">
                        @csrf
                        @method('DELETE')
                        <x-admin.button type="submit" variant="danger">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Supprimer
                        </x-admin.button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

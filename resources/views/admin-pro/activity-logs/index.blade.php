@extends('layouts.admin')

@section('title', 'Journaux d\'Activité')
@section('page-title', 'Journaux d\'Activité')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Journaux d'Activité</h1>
                <p class="mt-1 text-sm text-slate-600">Suivez toutes les actions effectuées sur la plateforme</p>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="document.getElementById('clearModal').classList.remove('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Nettoyer les Anciens Logs
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-5">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-600 truncate">Total</p>
                        <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['total']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Today -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-5">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-600 truncate">Aujourd'hui</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($stats['today']) }}</p>
                    </div>
                </div>
            </div>

            <!-- This Week -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-5">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-600 truncate">Cette Semaine</p>
                        <p class="text-2xl font-bold text-purple-600">{{ number_format($stats['this_week']) }}</p>
                    </div>
                </div>
            </div>

            <!-- This Month -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-5">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-600 truncate">Ce Mois</p>
                        <p class="text-2xl font-bold text-orange-600">{{ number_format($stats['this_month']) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Search -->
                    <div class="lg:col-span-2">
                        <label for="search" class="block text-sm font-medium text-slate-700 mb-2">
                            Rechercher
                        </label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            placeholder="Rechercher dans les descriptions..."
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    <!-- Module Filter -->
                    <div>
                        <label for="log_name" class="block text-sm font-medium text-slate-700 mb-2">
                            Module
                        </label>
                        <select id="log_name" name="log_name"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">Tous les modules</option>
                            @foreach ($logNames as $logName)
                                <option value="{{ $logName }}"
                                    {{ request('log_name') === $logName ? 'selected' : '' }}>
                                    {{ ucfirst($logName) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- User Filter -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-slate-700 mb-2">
                            Utilisateur
                        </label>
                        <select id="user_id" name="user_id"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">Tous les utilisateurs</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Event Filter -->
                    <div>
                        <label for="event" class="block text-sm font-medium text-slate-700 mb-2">
                            Type d'Action
                        </label>
                        <select id="event" name="event"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">Toutes les actions</option>
                            <option value="created" {{ request('event') === 'created' ? 'selected' : '' }}>Création
                            </option>
                            <option value="updated" {{ request('event') === 'updated' ? 'selected' : '' }}>Modification
                            </option>
                            <option value="deleted" {{ request('event') === 'deleted' ? 'selected' : '' }}>Suppression
                            </option>
                            <option value="login" {{ request('event') === 'login' ? 'selected' : '' }}>Connexion</option>
                            <option value="logout" {{ request('event') === 'logout' ? 'selected' : '' }}>Déconnexion
                            </option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Start Date -->
                    <div>

                        <x-admin.date-picker name="start_date" id="start_date" label="Date de début" :value="request('start_date')"
                            placeholder="Choisir une date" />
                    </div>

                    <!-- End Date -->
                    <div>


                        <x-admin.date-picker name="end_date" id="end_date" label="Date de Fin" :value="request('end_date')"
                            placeholder="Choisir une date" />
                    </div>

                    <!-- Buttons -->
                    <div class="lg:col-span-3 flex items-end gap-2">
                        <x-admin.button type="submit">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Filtrer
                        </x-admin.button>

                        @if (request()->hasAny(['search', 'log_name', 'user_id', 'event', 'start_date', 'end_date']))
                            <x-admin.button href="{{ route('admin.activity-logs.index') }}" variant="outline">
                                Réinitialiser
                            </x-admin.button>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Activity Timeline -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900">Historique des Activités</h2>
            </div>

            <div class="p-6">
                @forelse($logs as $log)
                    <div class="flex gap-4 pb-6 mb-6 border-b border-slate-200 last:border-0 last:pb-0 last:mb-0">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full {{ $log->color }} flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $log->icon }}" />
                                </svg>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-900">
                                        {{ $log->description }}
                                    </p>
                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 mt-2 text-xs text-slate-600">
                                        @if ($log->causer)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ $log->causer->full_name }}
                                            </span>
                                        @endif

                                        <span class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $log->created_at->diffForHumans() }}
                                        </span>

                                        @if ($log->ip_address)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                                </svg>
                                                {{ $log->ip_address }}
                                            </span>
                                        @endif

                                        @if ($log->log_name)
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                                {{ ucfirst($log->log_name) }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Changes Preview -->
                                    @if ($log->event === 'updated' && !empty($log->changes))
                                        <div class="mt-3 p-3 bg-slate-50 rounded-lg border border-slate-200">
                                            <p class="text-xs font-medium text-slate-700 mb-2">Modifications :</p>
                                            <div class="grid grid-cols-1 gap-2">
                                                @foreach ($log->changes as $key => $value)
                                                    <div class="flex items-center gap-2 text-xs">
                                                        <span
                                                            class="font-medium text-slate-600">{{ ucfirst($key) }}:</span>
                                                        @if (isset($log->old_values[$key]))
                                                            <span
                                                                class="text-red-600 line-through">{{ $log->old_values[$key] }}</span>
                                                            <span class="text-slate-400">→</span>
                                                        @endif
                                                        <span
                                                            class="text-green-600 font-medium">{{ $value }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-shrink-0 flex items-center gap-2">
                                    <a href="{{ route('admin.activity-logs.show', $log) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Détails
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-slate-100 rounded-full mx-auto flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-slate-900 mb-1">Aucune Activité</h3>
                        <p class="text-sm text-slate-500">Aucun journal d'activité trouvé.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if ($logs->hasPages())
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 px-4 py-3">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    <!-- Clear Logs Modal -->
    <div id="clearModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50"
        onclick="if(event.target === this) this.classList.add('hidden')">
        <div class="relative top-20 mx-auto p-0 w-full max-w-md">
            <div class="bg-white rounded-lg shadow-xl border border-slate-200">
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-orange-100 rounded-full">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-1.964-1.333-2.732 0L3.732 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 text-center mt-4">Nettoyer les Logs</h3>
                    <p class="text-sm text-slate-600 text-center mt-2 px-4">
                        Supprimez les anciens journaux d'activité pour libérer de l'espace.
                    </p>

                    <form method="POST" action="{{ route('admin.activity-logs.clear') }}" class="mt-4">
                        @csrf
                        @method('DELETE')

                        <div class="px-6">
                            <label for="days" class="block text-sm font-medium text-slate-700 mb-2">
                                Supprimer les logs plus anciens que :
                            </label>
                            <select name="days" id="days"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="30">30 jours</option>
                                <option value="60">60 jours</option>
                                <option value="90" selected>90 jours</option>
                                <option value="180">180 jours</option>
                                <option value="365">1 an</option>
                            </select>
                        </div>

                        <div class="px-6 pb-6 mt-4 space-y-3">
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-orange-600 text-white rounded-lg font-medium hover:bg-orange-700 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Nettoyer les Logs
                            </button>
                            <button type="button" onclick="document.getElementById('clearModal').classList.add('hidden')"
                                class="w-full px-4 py-3 bg-white border border-slate-300 rounded-lg font-medium text-slate-700 hover:bg-slate-50 transition">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

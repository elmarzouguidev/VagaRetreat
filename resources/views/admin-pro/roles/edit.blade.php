@extends('layouts.admin')

@section('title', 'Modifier le Rôle')
@section('page-title', 'Modifier le Rôle')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <x-admin.button href="{{ route('admin.roles.index') }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour aux Rôles
            </x-admin.button>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier le Rôle: {{ $role->label }}
                </h2>
                <p class="mt-1 text-sm text-slate-600">Modifiez les permissions de ce rôle</p>
            </div>

            <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Role Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                            Nom du Rôle <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required
                            placeholder="ex: content-manager"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-slate-500">Utilisez des lettres minuscules, chiffres et tirets
                            uniquement</p>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-slate-700 mb-2">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="3" placeholder="Décrivez les responsabilités de ce rôle..."
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Permissions -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-4">
                            Permissions <span class="text-red-500">*</span>
                        </label>

                        <div class="space-y-4">
                            @foreach ($permissions as $group => $groupPermissions)
                                <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="text-sm font-semibold text-slate-900">
                                            {{ __("permissions.groups.$group") !== "permissions.groups.$group" ? __("permissions.groups.$group") : ucfirst($group) }}
                                        </h4>
                                        <button type="button" onclick="toggleGroup('{{ $group }}')"
                                            class="text-xs text-blue-600 hover:text-blue-800">
                                            Tout sélectionner
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach ($groupPermissions as $permission)
                                            <label
                                                class="flex items-center gap-2 p-2 rounded hover:bg-white cursor-pointer transition">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                    class="permission-{{ $group }} w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500"
                                                    {{ $role->hasPermissionTo($permission->name) || in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                                <span class="text-sm text-slate-700">{{ $permission->label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @error('permissions')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-between pt-6 mt-6 border-t border-slate-200">
                    {{--<div>
                        @can('delete-roles')
                            @if (!in_array($role->name, ['super-admin', 'admin']))
                                <form method="POST" action="{{ route('admin.roles.destroy', $role) }}"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rôle ?')">
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
                            @endif
                        @endcan
                    </div>--}}

                    <div class="flex gap-3">
                        <x-admin.button href="{{ route('admin.roles.index') }}" variant="outline">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Annuler
                        </x-admin.button>
                        <x-admin.button type="submit">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Mettre à Jour
                        </x-admin.button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleGroup(group) {
                const checkboxes = document.querySelectorAll(`.permission-${group}`);
                const allChecked = Array.from(checkboxes).every(cb => cb.checked);

                checkboxes.forEach(checkbox => {
                    checkbox.checked = !allChecked;
                });
            }
        </script>
    @endpush
@endsection

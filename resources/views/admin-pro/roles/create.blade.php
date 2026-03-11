@extends('layouts.admin')

@section('title', 'Créer un Rôle')
@section('page-title', 'Créer un Rôle')

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
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Créer un Nouveau Rôle
                </h2>
                <p class="mt-1 text-sm text-slate-600">Définissez un nouveau rôle et ses permissions</p>
            </div>

            <form action="{{ route('admin.roles.store') }}" method="POST" class="p-6">
                @csrf

                <div class="space-y-6">
                    <!-- Role Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                            Nom du Rôle <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
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
                                            {{ ucfirst($group) }}
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
                                                    {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                                <span class="text-sm text-slate-700">{{ $permission->name }}</span>
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
                <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-slate-200">
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
                        Créer le Rôle
                    </x-admin.button>
                </div>
            </form>
        </div>
    </div>


@endsection
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

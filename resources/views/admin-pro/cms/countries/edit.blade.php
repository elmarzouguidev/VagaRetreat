@extends('layouts.admin')

@section('title', 'Modifier un pays')
@section('page-title', 'Modifier un pays')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <x-admin.button href="{{ route('admin.cms.countries.index') }}" variant="outline">Retour aux pays</x-admin.button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="text-lg font-medium text-slate-900">Modifier le pays</h2>
            </div>
            <form method="POST" action="{{ route('admin.cms.countries.update', $country) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                <x-admin.form-input label="Nom" name="name" :value="$country->name" required />
                <x-admin.form-input label="Code" name="code" :value="$country->code" required />
                <x-admin.form-input label="Slug" name="slug" :value="$country->slug" />
                <label class="flex items-center gap-3 text-sm text-slate-700">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500" @checked($country->is_active)>
                    Pays actif
                </label>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.cms.countries.index') }}" variant="outline">Annuler</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Mettre à jour</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

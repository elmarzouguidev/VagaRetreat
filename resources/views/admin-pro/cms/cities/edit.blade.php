@extends('layouts.admin')

@section('title', 'Modifier une ville')
@section('page-title', 'Modifier une ville')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <x-admin.button href="{{ route('admin.cms.cities.index') }}" variant="outline">Retour aux villes</x-admin.button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="text-lg font-medium text-slate-900">Modifier la ville</h2>
            </div>
            <form method="POST" action="{{ route('admin.cms.cities.update', $city) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                <x-admin.form-input label="Nom" name="name" :value="$city->name" required />
                <x-admin.form-input label="Slug" name="slug" :value="$city->slug" />
                <x-admin.form-input label="Code" name="code" :value="$city->code" />
                <x-admin.form-select label="Pays" name="country_id" :options="$countries->all()" :value="$city->country_id" placeholder="Sélectionner un pays" />
                <label class="flex items-center gap-3 text-sm text-slate-700">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500" @checked($city->is_active)>
                    Ville active
                </label>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.cms.cities.index') }}" variant="outline">Annuler</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Mettre à jour</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'Modifier un type de panier')
@section('page-title', 'Modifier un type de panier')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <x-admin.button href="{{ route('admin.cms.panier-types.index') }}" variant="outline">Retour aux types</x-admin.button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="text-lg font-medium text-slate-900">Modifier le type de panier</h2>
            </div>
            <form method="POST" action="{{ route('admin.cms.panier-types.update', $type) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                <x-admin.form-input label="Nom" name="name" :value="$type->name" required />
                <x-admin.textarea label="Description" name="content" :value="$type->content" rows="5" />
                <label class="flex items-center gap-3 text-sm text-slate-700">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500" @checked($type->is_active)>
                    Type actif
                </label>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.cms.panier-types.index') }}" variant="outline">Annuler</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Mettre à jour</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

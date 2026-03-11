@extends('layouts.admin')

@section('title', 'Créer un type d’enseigne')
@section('page-title', 'Créer un type d’enseigne')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <x-admin.button href="{{ route('admin.cms.enseigne-types.index') }}" variant="outline">Retour aux types</x-admin.button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="text-lg font-medium text-slate-900">Nouveau type d’enseigne</h2>
            </div>
            <form method="POST" action="{{ route('admin.cms.enseigne-types.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                <x-admin.form-input label="Nom" name="name" required />
                <x-admin.form-input label="Slug" name="slug" placeholder="Laisser vide pour génération automatique" />
                <x-admin.textarea label="Description" name="content" rows="5" />
                <x-admin.file-upload label="Visuel de couverture" name="cover" accept="image/*" />
                <label class="flex items-center gap-3 text-sm text-slate-700">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500" checked>
                    Type actif
                </label>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.cms.enseigne-types.index') }}" variant="outline">Annuler</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Créer le type</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'Créer une marque')
@section('page-title', 'Créer une marque')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-6">
            <x-admin.button href="{{ route('admin.cms.brands.index') }}" variant="outline">Retour aux marques</x-admin.button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="text-lg font-medium text-slate-900">Nouvelle marque</h2>
            </div>
            <form method="POST" action="{{ route('admin.cms.brands.store') }}" enctype="multipart/form-data" class="space-y-6 p-6">
                @csrf
                <x-admin.form-input label="Nom" name="name" required />
                <x-admin.form-input label="Slug" name="slug" placeholder="Laisser vide pour générer automatiquement" />
                <x-admin.textarea label="Description" name="content" rows="4" placeholder="Description de la marque..." />
                <x-admin.form-input label="Logo" name="logo" type="file" accept="image/*" />
                <label class="flex items-center gap-3 text-sm text-slate-700">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500" checked>
                    Marque active
                </label>
                <div class="flex justify-end gap-3 border-t border-slate-200 pt-4">
                    <x-admin.button href="{{ route('admin.cms.brands.index') }}" variant="outline">Annuler</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Créer la marque</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

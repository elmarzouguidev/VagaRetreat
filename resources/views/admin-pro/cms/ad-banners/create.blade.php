@extends('layouts.admin')

@section('title', 'Créer une bannière publicitaire')
@section('page-title', 'Créer une bannière publicitaire')

@section('content')
    <div class="mx-auto max-w-4xl">
        <div class="mb-6">
            <x-admin.button href="{{ route('admin.cms.ad-banners.index') }}" variant="outline">Retour aux bannières</x-admin.button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="text-lg font-medium text-slate-900">Nouvelle bannière</h2>
            </div>
            <form method="POST" action="{{ route('admin.cms.ad-banners.store') }}" enctype="multipart/form-data" class="space-y-6 p-6">
                @csrf

                <div class="grid gap-6 md:grid-cols-2">
                    <x-admin.form-input label="Titre" name="title" />
                    <x-admin.form-input label="Nombre de vues initial" name="views" type="number" min="0" value="0" />
                </div>

                <x-admin.textarea label="Description" name="content" rows="4" placeholder="Texte de la bannière..." />
                <x-admin.form-input label="Image" name="image" type="file" accept="image/*" required />

                <div class="grid gap-6 md:grid-cols-3">
                    <x-admin.form-select label="Utilisateur lié" name="user_id" :options="$users" placeholder="Aucun utilisateur" />
                    <x-admin.form-select label="Enseigne liée" name="enseigne_id" :options="$enseignes" placeholder="Aucune enseigne" />
                    <x-admin.form-select label="Ville liée" name="city_id" :options="$cities" placeholder="Toutes les villes" />
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <x-admin.form-input label="Lien URL" name="link_url" type="url" placeholder="https://..." />
                    <x-admin.form-input label="Texte du lien" name="link_text" placeholder="Découvrir" />
                </div>

                <label class="flex items-center gap-3 text-sm text-slate-700">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500" checked>
                    Bannière active
                </label>

                <div class="flex justify-end gap-3 border-t border-slate-200 pt-4">
                    <x-admin.button href="{{ route('admin.cms.ad-banners.index') }}" variant="outline">Annuler</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Créer la bannière</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

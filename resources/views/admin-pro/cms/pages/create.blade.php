@extends('layouts.admin')

@section('title', 'Créer une page CMS')
@section('page-title', 'Créer une page CMS')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <x-admin.button href="{{ route('admin.cms.pages.index') }}" variant="outline">Retour aux pages</x-admin.button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="text-lg font-medium text-slate-900">Nouvelle page CMS</h2>
            </div>
            <form method="POST" action="{{ route('admin.cms.pages.store') }}" class="p-6 space-y-6">
                @csrf
                <x-admin.form-input label="Titre" name="title" required />
                <x-admin.form-input label="Slug" name="slug" placeholder="Laisser vide pour génération automatique" />
                <x-admin.tinymce-editor label="Contenu" name="body" :value="old('body', '')" />
                <x-admin.form-input label="Meta title" name="meta_title" />
                <x-admin.textarea label="Meta description" name="meta_description" rows="3" />
                <label class="flex items-center gap-3 text-sm text-slate-700">
                    <input type="checkbox" name="is_published" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    Publier immédiatement
                </label>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.cms.pages.index') }}" variant="outline">Annuler</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Créer la page</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

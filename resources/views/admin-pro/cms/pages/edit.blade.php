@extends('layouts.admin')

@section('title', 'Modifier une page CMS')
@section('page-title', 'Modifier une page CMS')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <x-admin.button href="{{ route('admin.cms.pages.index') }}" variant="outline">Retour aux pages</x-admin.button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="text-lg font-medium text-slate-900">Modifier la page CMS</h2>
            </div>
            <form method="POST" action="{{ route('admin.cms.pages.update', $page) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                <x-admin.form-input label="Titre" name="title" :value="$page->title" required />
                <x-admin.form-input label="Slug" name="slug" :value="$page->slug" />
                <x-admin.tinymce-editor label="Contenu" name="body" :value="$page->body ?? ''" />
                <x-admin.form-input label="Meta title" name="meta_title" :value="$page->meta_title" />
                <x-admin.textarea label="Meta description" name="meta_description" :value="$page->meta_description" rows="3" />
                <label class="flex items-center gap-3 text-sm text-slate-700">
                    <input type="checkbox" name="is_published" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500" @checked($page->is_published)>
                    Page publiée
                </label>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.cms.pages.index') }}" variant="outline">Annuler</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Mettre à jour</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

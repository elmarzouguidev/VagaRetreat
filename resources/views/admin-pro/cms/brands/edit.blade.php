@extends('layouts.admin')

@section('title', 'Modifier une marque')
@section('page-title', 'Modifier une marque')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-6">
            <x-admin.button href="{{ route('admin.cms.brands.index') }}" variant="outline">Retour aux marques</x-admin.button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="text-lg font-medium text-slate-900">Modifier la marque</h2>
            </div>
            <form method="POST" action="{{ route('admin.cms.brands.update', $brand) }}" enctype="multipart/form-data" class="space-y-6 p-6">
                @csrf
                @method('PUT')
                <x-admin.form-input label="Nom" name="name" :value="$brand->name" required />
                <x-admin.form-input label="Slug" name="slug" :value="$brand->slug" placeholder="Laisser vide pour générer automatiquement" />
                <x-admin.textarea label="Description" name="content" rows="4" :value="$brand->content" placeholder="Description de la marque..." />
                <x-admin.form-input label="Logo" name="logo" type="file" accept="image/*" />
                @if ($brand->getFirstMediaUrl('brands_logos'))
                    <div>
                        <p class="mb-2 text-sm font-medium text-slate-700">Logo actuel</p>
                        <img src="{{ $brand->getFirstMediaUrl('brands_logos') }}" alt="{{ $brand->name }}" class="h-20 w-32 rounded-lg border border-slate-200 object-cover">
                    </div>
                @endif
                <label class="flex items-center gap-3 text-sm text-slate-700">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500" @checked($brand->is_active)>
                    Marque active
                </label>
                <div class="flex justify-end gap-3 border-t border-slate-200 pt-4">
                    <x-admin.button href="{{ route('admin.cms.brands.index') }}" variant="outline">Annuler</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Mettre à jour</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

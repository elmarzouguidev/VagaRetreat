@extends('layouts.admin')

@section('title', 'Modifier une méthode de paiement')
@section('page-title', 'Modifier une méthode de paiement')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-6">
            <x-admin.button href="{{ route('admin.cms.payment-methods.index') }}" variant="outline">Retour aux méthodes</x-admin.button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="text-lg font-medium text-slate-900">Modifier la méthode de paiement</h2>
            </div>
            <form method="POST" action="{{ route('admin.cms.payment-methods.update', $paymentMethod) }}" class="space-y-6 p-6">
                @csrf
                @method('PUT')
                <x-admin.form-input label="Nom" name="name" :value="$paymentMethod->name" required />
                <x-admin.form-select label="Devise par défaut" name="default_currency" :options="$currencies" :value="$paymentMethod->default_currency?->value ?? $paymentMethod->default_currency" required />
                <x-admin.textarea label="Description" name="content" rows="4" :value="$paymentMethod->content" placeholder="Description de la méthode de paiement..." />
                <label class="flex items-center gap-3 text-sm text-slate-700">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500" @checked($paymentMethod->is_active)>
                    Méthode active
                </label>
                <div class="flex justify-end gap-3 border-t border-slate-200 pt-4">
                    <x-admin.button href="{{ route('admin.cms.payment-methods.index') }}" variant="outline">Annuler</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Mettre à jour</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

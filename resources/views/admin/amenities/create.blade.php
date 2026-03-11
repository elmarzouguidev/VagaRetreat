@extends('layouts.admin')

@section('title', 'Create Amenity')
@section('page-title', 'Create Amenity')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <div>
            <x-admin.button href="{{ route('admin.amenities.index') }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Amenities
            </x-admin.button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="text-lg font-medium text-slate-900">New Amenity (Feature / Service)</h2>
            </div>
            
            <form method="POST" action="{{ route('admin.amenities.store') }}" class="p-6 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-admin.form-input label="Amenity Name" name="name" required placeholder="e.g. Free Wi-Fi, Pool" />
                    <x-admin.form-input label="Slug" name="slug" placeholder="Auto-generated if empty" />
                </div>
                
                <div class="grid grid-cols-1 gap-6">
                    <x-admin.form-input label="Icon (SVG string or class)" name="icon" placeholder="<svg>...</svg> or fa-solid fa-wifi" />
                    <x-admin.textarea label="Description (Optional)" name="description" rows="3" placeholder="Brief details about this amenity..." />
                </div>

                <div class="flex flex-col gap-3 py-4 border-t border-slate-100">
                    <label class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                        <input type="checkbox" name="is_active" value="1" class="w-5 h-5 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500/20" checked>
                        Active (Visible on frontend selections)
                    </label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.amenities.index') }}" variant="outline">Cancel</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Create Amenity</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

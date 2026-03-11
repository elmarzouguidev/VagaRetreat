@extends('layouts.admin')

@section('title', 'Edit Destination: ' . $city->name)
@section('page-title', 'Edit Destination')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <div>
            <x-admin.button href="{{ route('admin.cities.index') }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Destinations
            </x-admin.button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="text-lg font-medium text-slate-900">Edit Destination (City): {{ $city->name }}</h2>
            </div>
            
            <form method="POST" action="{{ route('admin.cities.update', $city) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    <x-admin.form-input label="City Name" name="name" :value="$city->name" required />
                    <x-admin.form-input label="Slug" name="slug" :value="$city->slug" />

                    <div>
                        <label for="country_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Country (Optional)</label>
                        <select name="country_id" id="country_id" class="w-full px-4 py-2 bg-slate-50/50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all duration-200">
                            <option value="">-- None --</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id', $city->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col gap-3 py-4 border-t border-slate-100">
                    <label class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                        <input type="checkbox" name="is_active" value="1" class="w-5 h-5 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500/20" @checked($city->is_active)>
                        Active (Visible on frontend selections)
                    </label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.cities.index') }}" variant="outline">Cancel</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Update Destination</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

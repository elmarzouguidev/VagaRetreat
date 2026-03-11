@extends('layouts.admin')

@section('title', 'Edit Itinerary Day - ' . $tour->title)
@section('page-title', 'Edit Itinerary Day')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div>
            <x-admin.button :href="route('admin.tours.show', $tour)" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to {{ $tour->title }}
            </x-admin.button>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900">Edit Itinerary Day: {{ Str::limit($plan->title, 40) }}</h2>
            </div>
            
            <form action="{{ route('admin.tours.plans.update', [$tour, $plan]) }}" method="POST" class="p-6 space-y-6 cursor-text">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <x-admin.form-input label="Title / Headline" name="title" :value="$plan->title" required />
                     <x-admin.form-input label="Specific Date (Optional)" name="plan_date" type="date" :value="$plan->plan_date ? $plan->plan_date->format('Y-m-d') : ''" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <x-admin.form-input label="Start Time (Optional)" name="start_at" type="time" :value="$plan->start_at ? $plan->start_at->format('H:i') : ''" />
                     <x-admin.form-input label="End Time (Optional)" name="end_at" type="time" :value="$plan->end_at ? $plan->end_at->format('H:i') : ''" />
                </div>
               
                <x-admin.textarea label="Description" name="description" rows="5" :value="$plan->description" />

                <div class="flex flex-col gap-3 py-4 border-t border-slate-100">
                    <label class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                        <input type="checkbox" name="is_active" value="1" class="w-5 h-5 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500/20" @checked($plan->is_active)>
                        Active (Visible on frontend)
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button :href="route('admin.tours.show', $tour)" variant="outline">Cancel</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Update Itinerary Day</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

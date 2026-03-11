@extends('layouts.admin')

@section('title', 'Webhook Event #' . $event->id)
@section('page-title', 'Webhook Event Details')

@section('content')
    @php
        $payloadJson = json_encode($event->payload ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '{}';
    @endphp
    <div class="max-w-[95rem] mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">{{ $event->event_type }}</h2>
                <p class="text-xs text-slate-500 mt-1 font-mono">{{ $event->stripe_event_id }}</p>
            </div>
            <a href="{{ route('admin.monitoring.async.index') }}"
                class="px-3 py-1.5 text-xs font-medium rounded-md border border-slate-300 text-slate-700 hover:bg-slate-100">
                Back
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg border border-slate-200 p-4">
                <p class="text-xs text-slate-500">Status</p>
                <p class="text-sm font-semibold text-slate-800 mt-1">{{ $event->status }}</p>
            </div>
            <div class="bg-white rounded-lg border border-slate-200 p-4">
                <p class="text-xs text-slate-500">Processed At</p>
                <p class="text-sm font-semibold text-slate-800 mt-1">{{ $event->processed_at?->format('Y-m-d H:i:s') ?? '-' }}</p>
            </div>
            <div class="bg-white rounded-lg border border-slate-200 p-4">
                <p class="text-xs text-slate-500">Updated At</p>
                <p class="text-sm font-semibold text-slate-800 mt-1">{{ $event->updated_at?->format('Y-m-d H:i:s') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200">
            <div class="px-4 py-3 border-b border-slate-200">
                <h3 class="text-sm font-semibold text-slate-800">Error</h3>
            </div>
            <div class="p-4">
                <pre class="text-xs text-red-700 whitespace-pre-wrap">{{ $event->error ?? '-' }}</pre>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200">
            <div class="px-4 py-3 border-b border-slate-200">
                <h3 class="text-sm font-semibold text-slate-800">Payload JSON</h3>
            </div>
            <div class="p-4">
                <pre class="text-sm font-mono text-slate-100 bg-slate-900 rounded-lg p-5 overflow-auto whitespace-pre min-h-[480px] max-h-[75vh]"><code>{{ $payloadJson }}</code></pre>
            </div>
        </div>
    </div>
@endsection

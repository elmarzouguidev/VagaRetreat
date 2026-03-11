@extends('layouts.admin')

@section('title', 'Report Run #' . $reportRun->id)
@section('page-title', 'Report Run Details')

@section('content')
    @php
        $filesJson = json_encode($reportRun->files ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '{}';
        $metaJson = json_encode($reportRun->meta ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '{}';
    @endphp
    <div class="max-w-[95rem] mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">{{ $reportRun->report_type }}</h2>
                <p class="text-xs text-slate-500 mt-1 font-mono">{{ $reportRun->idempotency_key }}</p>
            </div>
            <a href="{{ route('admin.monitoring.async.index') }}"
                class="px-3 py-1.5 text-xs font-medium rounded-md border border-slate-300 text-slate-700 hover:bg-slate-100">
                Back
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg border border-slate-200 p-4">
                <p class="text-xs text-slate-500">Status</p>
                <p class="text-sm font-semibold text-slate-800 mt-1">{{ $reportRun->status }}</p>
            </div>
            <div class="bg-white rounded-lg border border-slate-200 p-4">
                <p class="text-xs text-slate-500">Period</p>
                <p class="text-sm font-semibold text-slate-800 mt-1">{{ $reportRun->period_label ?? '-' }}</p>
            </div>
            <div class="bg-white rounded-lg border border-slate-200 p-4">
                <p class="text-xs text-slate-500">Window</p>
                <p class="text-sm font-semibold text-slate-800 mt-1">
                    {{ $reportRun->start_date?->format('Y-m-d H:i') }} -> {{ $reportRun->end_date?->format('Y-m-d H:i') }}
                </p>
            </div>
            <div class="bg-white rounded-lg border border-slate-200 p-4">
                <p class="text-xs text-slate-500">Notification Sent</p>
                <p class="text-sm font-semibold text-slate-800 mt-1">{{ $reportRun->notification_sent_at?->format('Y-m-d H:i:s') ?? '-' }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200">
            <div class="px-4 py-3 border-b border-slate-200">
                <h3 class="text-sm font-semibold text-slate-800">Error</h3>
            </div>
            <div class="p-4">
                <pre class="text-xs text-red-700 whitespace-pre-wrap">{{ $reportRun->error ?? '-' }}</pre>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200">
            <div class="px-4 py-3 border-b border-slate-200">
                <h3 class="text-sm font-semibold text-slate-800">Files JSON</h3>
            </div>
            <div class="p-4">
                <pre class="text-sm font-mono text-slate-100 bg-slate-900 rounded-lg p-5 overflow-auto whitespace-pre min-h-[380px] max-h-[65vh]"><code>{{ $filesJson }}</code></pre>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200">
            <div class="px-4 py-3 border-b border-slate-200">
                <h3 class="text-sm font-semibold text-slate-800">Meta JSON</h3>
            </div>
            <div class="p-4">
                <pre class="text-sm font-mono text-slate-100 bg-slate-900 rounded-lg p-5 overflow-auto whitespace-pre min-h-[480px] max-h-[75vh]"><code>{{ $metaJson }}</code></pre>
            </div>
        </div>
    </div>
@endsection

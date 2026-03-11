@extends('layouts.admin')

@section('title', 'Monitoring Async')
@section('page-title', 'Monitoring Async')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 p-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
            <div class="rounded-lg border border-slate-200 bg-white p-4">
                <p class="text-xs font-medium text-slate-500">Webhooks Total</p>
                <p class="text-2xl font-semibold text-slate-900 mt-1">{{ $webhookMetrics['total'] }}</p>
            </div>
            <div class="rounded-lg border border-red-200 bg-red-50 p-4">
                <p class="text-xs font-medium text-red-700">Webhooks Failed</p>
                <p class="text-2xl font-semibold text-red-700 mt-1">{{ $webhookMetrics['failed'] }}</p>
            </div>
            <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">
                <p class="text-xs font-medium text-amber-700">Webhooks Processing</p>
                <p class="text-2xl font-semibold text-amber-700 mt-1">{{ $webhookMetrics['processing'] }}</p>
            </div>
            <div class="rounded-lg border border-orange-200 bg-orange-50 p-4">
                <p class="text-xs font-medium text-orange-700">Webhooks Stuck</p>
                <p class="text-2xl font-semibold text-orange-700 mt-1">{{ $webhookMetrics['stuck'] }}</p>
            </div>
            <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                <p class="text-xs font-medium text-blue-700">Webhooks Last 24h</p>
                <p class="text-2xl font-semibold text-blue-700 mt-1">{{ $webhookMetrics['last_24h'] }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
            <div class="rounded-lg border border-slate-200 bg-white p-4">
                <p class="text-xs font-medium text-slate-500">Reports Total</p>
                <p class="text-2xl font-semibold text-slate-900 mt-1">{{ $reportMetrics['total'] }}</p>
            </div>
            <div class="rounded-lg border border-red-200 bg-red-50 p-4">
                <p class="text-xs font-medium text-red-700">Reports Failed</p>
                <p class="text-2xl font-semibold text-red-700 mt-1">{{ $reportMetrics['failed'] }}</p>
            </div>
            <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">
                <p class="text-xs font-medium text-amber-700">Reports Processing</p>
                <p class="text-2xl font-semibold text-amber-700 mt-1">{{ $reportMetrics['processing'] }}</p>
            </div>
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4">
                <p class="text-xs font-medium text-emerald-700">Reports Completed</p>
                <p class="text-2xl font-semibold text-emerald-700 mt-1">{{ $reportMetrics['completed'] }}</p>
            </div>
            <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                <p class="text-xs font-medium text-blue-700">Reports Last 24h</p>
                <p class="text-2xl font-semibold text-blue-700 mt-1">{{ $reportMetrics['last_24h'] }}</p>
            </div>
        </div>

        @if (config('refund.enabled', true))
            <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                <div class="rounded-lg border border-slate-200 bg-white p-4">
                    <p class="text-xs font-medium text-slate-500">Refunds Total</p>
                    <p class="text-2xl font-semibold text-slate-900 mt-1">{{ $refundMetrics['total'] }}</p>
                </div>
                <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">
                    <p class="text-xs font-medium text-amber-700">Refunds Pending</p>
                    <p class="text-2xl font-semibold text-amber-700 mt-1">{{ $refundMetrics['pending'] }}</p>
                </div>
                <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                    <p class="text-xs font-medium text-blue-700">Approved (Queue)</p>
                    <p class="text-2xl font-semibold text-blue-700 mt-1">{{ $refundMetrics['approved'] }}</p>
                </div>
                <div class="rounded-lg border border-red-200 bg-red-50 p-4">
                    <p class="text-xs font-medium text-red-700">Refunds Failed</p>
                    <p class="text-2xl font-semibold text-red-700 mt-1">{{ $refundMetrics['failed'] }}</p>
                </div>
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4">
                    <p class="text-xs font-medium text-emerald-700">Processed Last 24h</p>
                    <p class="text-2xl font-semibold text-emerald-700 mt-1">{{ $refundMetrics['processed_24h'] }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Stripe Webhook Events</h2>
                        <p class="text-xs text-slate-500 mt-1">Statuses: received, dispatched, processing, processed, failed</p>
                    </div>
                    <form method="POST" action="{{ route('admin.monitoring.async.webhooks.retry-failed') }}"
                        onsubmit="return confirm('Retry all failed webhook events?')">
                        @csrf
                        <button type="submit"
                            class="px-3 py-1.5 text-xs font-medium rounded-md bg-amber-600 text-white hover:bg-amber-700">
                            Retry All Failed
                        </button>
                    </form>
                </div>
            </div>

            <form method="GET" class="px-6 py-4 border-b border-slate-200 bg-slate-50/50">
                <div class="grid grid-cols-1 md:grid-cols-8 gap-3">
                    <input type="text" name="wh_event_id" value="{{ request('wh_event_id') }}"
                        placeholder="Event ID..."
                        class="px-3 py-2 text-sm border border-slate-300 rounded-md md:col-span-2">

                    <select name="wh_type" class="px-3 py-2 text-sm border border-slate-300 rounded-md">
                        <option value="">All types</option>
                        @foreach ($webhookTypes as $type)
                            <option value="{{ $type }}" @selected(request('wh_type') === $type)>{{ $type }}</option>
                        @endforeach
                    </select>

                    <select name="wh_status" class="px-3 py-2 text-sm border border-slate-300 rounded-md">
                        <option value="">All statuses</option>
                        @foreach ($webhookStatuses as $status)
                            <option value="{{ $status }}" @selected(request('wh_status') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>

                    <input type="date" name="wh_from" value="{{ request('wh_from') }}"
                        class="px-3 py-2 text-sm border border-slate-300 rounded-md">
                    <input type="date" name="wh_to" value="{{ request('wh_to') }}"
                        class="px-3 py-2 text-sm border border-slate-300 rounded-md">

                    <select name="wh_last_hours" class="px-3 py-2 text-sm border border-slate-300 rounded-md">
                        <option value="">Any time</option>
                        <option value="24" @selected(request('wh_last_hours') == '24')>Last 24h</option>
                        <option value="72" @selected(request('wh_last_hours') == '72')>Last 72h</option>
                        <option value="168" @selected(request('wh_last_hours') == '168')>Last 7 days</option>
                    </select>

                    <label class="inline-flex items-center gap-2 px-3 py-2 text-sm border border-slate-300 rounded-md bg-white">
                        <input type="checkbox" name="wh_errors_only" value="1" @checked(request()->boolean('wh_errors_only'))>
                        <span>Errors only</span>
                    </label>

                    <label class="inline-flex items-center gap-2 px-3 py-2 text-sm border border-slate-300 rounded-md bg-white">
                        <input type="checkbox" name="wh_stuck_only" value="1" @checked(request()->boolean('wh_stuck_only'))>
                        <span>Stuck only</span>
                    </label>
                </div>
                <div class="mt-3 flex items-center gap-2">
                    <button type="submit"
                        class="px-3 py-1.5 text-xs font-medium rounded-md bg-slate-800 text-white hover:bg-slate-900">Filter</button>
                    <a href="{{ route('admin.monitoring.async.index') }}"
                        class="px-3 py-1.5 text-xs font-medium rounded-md border border-slate-300 text-slate-600 hover:bg-slate-100">Reset</a>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Event ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Error</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Updated</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($webhookEvents as $event)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-sm text-slate-700">{{ $event->id }}</td>
                                <td class="px-4 py-3 text-xs font-mono text-slate-700">{{ $event->stripe_event_id }}</td>
                                <td class="px-4 py-3 text-sm text-slate-700">{{ $event->event_type }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full bg-slate-100 text-slate-700">{{ $event->status }}</span>
                                </td>
                                <td class="px-4 py-3 text-xs text-red-600 max-w-sm truncate" title="{{ $event->error }}">
                                    {{ $event->error ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-xs text-slate-500">{{ $event->updated_at?->format('Y-m-d H:i:s') }}</td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.monitoring.async.webhooks.show', $event) }}"
                                            class="px-3 py-1.5 text-xs font-medium rounded-md border border-slate-300 text-slate-700 hover:bg-slate-100">
                                            View
                                        </a>
                                        @if (in_array($event->status, ['failed', 'received', 'dispatched']))
                                            <form method="POST" action="{{ route('admin.monitoring.async.webhooks.retry', $event) }}">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1.5 text-xs font-medium rounded-md bg-blue-600 text-white hover:bg-blue-700">
                                                    Retry
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">No webhook events.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-slate-200">
                {{ $webhookEvents->links() }}
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Report Runs</h2>
                        <p class="text-xs text-slate-500 mt-1">Statuses: processing, completed, failed</p>
                    </div>
                    <form method="POST" action="{{ route('admin.monitoring.async.reports.retry-failed') }}"
                        onsubmit="return confirm('Retry all failed report runs?')">
                        @csrf
                        <button type="submit"
                            class="px-3 py-1.5 text-xs font-medium rounded-md bg-amber-600 text-white hover:bg-amber-700">
                            Retry All Failed
                        </button>
                    </form>
                </div>
            </div>

            <form method="GET" class="px-6 py-4 border-b border-slate-200 bg-slate-50/50">
                <div class="grid grid-cols-1 md:grid-cols-8 gap-3">
                    <input type="text" name="rr_key" value="{{ request('rr_key') }}"
                        placeholder="Idempotency key..."
                        class="px-3 py-2 text-sm border border-slate-300 rounded-md md:col-span-2">

                    <select name="rr_type" class="px-3 py-2 text-sm border border-slate-300 rounded-md">
                        <option value="">All types</option>
                        @foreach ($reportTypes as $type)
                            <option value="{{ $type }}" @selected(request('rr_type') === $type)>{{ $type }}</option>
                        @endforeach
                    </select>

                    <select name="rr_status" class="px-3 py-2 text-sm border border-slate-300 rounded-md">
                        <option value="">All statuses</option>
                        @foreach ($reportStatuses as $status)
                            <option value="{{ $status }}" @selected(request('rr_status') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>

                    <input type="date" name="rr_from" value="{{ request('rr_from') }}"
                        class="px-3 py-2 text-sm border border-slate-300 rounded-md">
                    <input type="date" name="rr_to" value="{{ request('rr_to') }}"
                        class="px-3 py-2 text-sm border border-slate-300 rounded-md">

                    <select name="rr_last_hours" class="px-3 py-2 text-sm border border-slate-300 rounded-md">
                        <option value="">Any time</option>
                        <option value="24" @selected(request('rr_last_hours') == '24')>Last 24h</option>
                        <option value="72" @selected(request('rr_last_hours') == '72')>Last 72h</option>
                        <option value="168" @selected(request('rr_last_hours') == '168')>Last 7 days</option>
                    </select>

                    <label class="inline-flex items-center gap-2 px-3 py-2 text-sm border border-slate-300 rounded-md bg-white">
                        <input type="checkbox" name="rr_errors_only" value="1" @checked(request()->boolean('rr_errors_only'))>
                        <span>Errors only</span>
                    </label>
                </div>
                <div class="mt-3 flex items-center gap-2">
                    <button type="submit"
                        class="px-3 py-1.5 text-xs font-medium rounded-md bg-slate-800 text-white hover:bg-slate-900">Filter</button>
                    <a href="{{ route('admin.monitoring.async.index') }}"
                        class="px-3 py-1.5 text-xs font-medium rounded-md border border-slate-300 text-slate-600 hover:bg-slate-100">Reset</a>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Window</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Error</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Updated</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($reportRuns as $run)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-sm text-slate-700">{{ $run->id }}</td>
                                <td class="px-4 py-3 text-sm text-slate-700">{{ $run->report_type }}</td>
                                <td class="px-4 py-3 text-xs text-slate-700">
                                    {{ $run->start_date?->format('Y-m-d H:i') }} -> {{ $run->end_date?->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full bg-slate-100 text-slate-700">{{ $run->status }}</span>
                                </td>
                                <td class="px-4 py-3 text-xs text-red-600 max-w-sm truncate" title="{{ $run->error }}">
                                    {{ $run->error ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-xs text-slate-500">{{ $run->updated_at?->format('Y-m-d H:i:s') }}</td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.monitoring.async.reports.show', $run) }}"
                                            class="px-3 py-1.5 text-xs font-medium rounded-md border border-slate-300 text-slate-700 hover:bg-slate-100">
                                            View
                                        </a>
                                        @if ($run->status === 'failed')
                                            <form method="POST" action="{{ route('admin.monitoring.async.reports.retry', $run) }}">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1.5 text-xs font-medium rounded-md bg-blue-600 text-white hover:bg-blue-700">
                                                    Retry
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">No report runs.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-slate-200">
                {{ $reportRuns->links() }}
            </div>
        </div>
    </div>
@endsection

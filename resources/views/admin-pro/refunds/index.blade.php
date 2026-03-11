@extends('layouts.admin')

@section('title', 'Refund Requests')
@section('page-title', 'Refund Requests')

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

        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900">Refund Requests</h2>
            </div>

            <form method="GET" class="px-6 py-4 border-b border-slate-200 bg-slate-50/50">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="UUID / order / transaction / email"
                        class="px-3 py-2 text-sm border border-slate-300 rounded-md md:col-span-2">

                    <select name="status" class="px-3 py-2 text-sm border border-slate-300 rounded-md">
                        <option value="">All statuses</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-3 flex items-center gap-2">
                    <button type="submit"
                        class="px-3 py-1.5 text-xs font-medium rounded-md bg-slate-800 text-white hover:bg-slate-900">Filter</button>
                    <a href="{{ route('admin.refunds.index') }}"
                        class="px-3 py-1.5 text-xs font-medium rounded-md border border-slate-300 text-slate-600 hover:bg-slate-100">Reset</a>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">UUID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Client</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Transaction</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Created</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($refundRequests as $refund)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-xs font-mono text-slate-700">{{ $refund->uuid }}</td>
                                <td class="px-4 py-3 text-sm text-slate-700">{{ $refund->user?->full_name ?? $refund->user?->email }}</td>
                                <td class="px-4 py-3 text-sm text-slate-700">{{ $refund->transaction?->transaction_number ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-slate-700">{{ number_format(((int) $refund->amount) / 100, 2) }} {{ strtoupper($refund->currency ?? 'MAD') }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full bg-slate-100 text-slate-700">{{ $refund->status }}</span>
                                </td>
                                <td class="px-4 py-3 text-xs text-slate-500">{{ $refund->created_at?->format('Y-m-d H:i:s') }}</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.refunds.show', $refund) }}"
                                        class="px-3 py-1.5 text-xs font-medium rounded-md border border-slate-300 text-slate-700 hover:bg-slate-100">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">No refund requests.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-slate-200">
                {{ $refundRequests->links() }}
            </div>
        </div>
    </div>
@endsection


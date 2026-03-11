@extends('layouts.admin')

@section('title', 'Refund Request')
@section('page-title', 'Refund Request Details')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">
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
                <h2 class="text-lg font-semibold text-slate-900">Refund {{ $refundRequest->uuid }}</h2>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><span class="text-slate-500">Status:</span> <strong>{{ $refundRequest->status }}</strong></div>
                <div><span class="text-slate-500">Amount:</span> <strong>{{ number_format(((int) $refundRequest->amount) / 100, 2) }} {{ strtoupper($refundRequest->currency ?? 'MAD') }}</strong></div>
                <div><span class="text-slate-500">Client:</span> {{ $refundRequest->user?->full_name }} ({{ $refundRequest->user?->email }})</div>
                <div><span class="text-slate-500">Transaction:</span> {{ $refundRequest->transaction?->transaction_number ?? 'N/A' }}</div>
                <div><span class="text-slate-500">Commande:</span> {{ $refundRequest->command?->command_number ?? 'N/A' }}</div>
                <div><span class="text-slate-500">Reviewed by:</span> {{ $refundRequest->reviewer?->full_name ?? '-' }}</div>
                <div class="md:col-span-2"><span class="text-slate-500">Reason:</span> {{ $refundRequest->reason }}</div>
                <div class="md:col-span-2"><span class="text-slate-500">Review note:</span> {{ $refundRequest->review_note ?? '-' }}</div>
                <div class="md:col-span-2"><span class="text-slate-500">Error:</span> <span class="text-red-600">{{ $refundRequest->error ?? '-' }}</span></div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 space-y-4">
            @if ($refundRequest->status === \App\Modules\Refund\Models\RefundRequest::STATUS_PENDING)
                <form method="POST" action="{{ route('admin.refunds.approve', $refundRequest) }}" class="space-y-2">
                    @csrf
                    <label class="block text-sm font-medium text-slate-700">Approve note (optional)</label>
                    <textarea name="review_note" rows="3" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-md"></textarea>
                    <button type="submit" class="px-4 py-2 text-sm font-medium rounded-md bg-emerald-600 text-white hover:bg-emerald-700">
                        Approve & Queue Processing
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.refunds.reject', $refundRequest) }}" class="space-y-2">
                    @csrf
                    <label class="block text-sm font-medium text-slate-700">Reject note (required)</label>
                    <textarea name="review_note" rows="3" required class="w-full px-3 py-2 text-sm border border-slate-300 rounded-md"></textarea>
                    <button type="submit" class="px-4 py-2 text-sm font-medium rounded-md bg-red-600 text-white hover:bg-red-700">
                        Reject Request
                    </button>
                </form>
            @elseif (in_array($refundRequest->status, [\App\Modules\Refund\Models\RefundRequest::STATUS_APPROVED, \App\Modules\Refund\Models\RefundRequest::STATUS_FAILED]))
                <form method="POST" action="{{ route('admin.refunds.process', $refundRequest) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-sm font-medium rounded-md bg-blue-600 text-white hover:bg-blue-700">
                        Queue Processing
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection


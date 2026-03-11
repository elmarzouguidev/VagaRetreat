@extends('layouts.admin')

@section('title', 'Pickup Details')
@section('page-title', 'Pickup - ' . $command->command_number)

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">
        <div>
            <x-admin.button href="{{ route('admin.pickups.index') }}" variant="outline">Back to Pickups</x-admin.button>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Order Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-slate-500">Order</p>
                    <p class="font-medium text-slate-900">{{ $command->command_number }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Client</p>
                    <p class="font-medium text-slate-900">{{ $command->user?->full_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Order Status</p>
                    <p class="font-medium text-slate-900">{{ $command->status?->label() ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Collect Day</p>
                    <p class="font-medium text-slate-900">{{ $command->panier?->collect_day?->format('d/m/Y') ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Collect Time</p>
                    <p class="font-medium text-slate-900">
                        {{ $command->panier?->collect_time_start?->format('H:i') ?? '--:--' }} -
                        {{ $command->panier?->collect_time_end?->format('H:i') ?? '--:--' }}
                    </p>
                </div>
                <div>
                    <p class="text-slate-500">Collected At</p>
                    <p class="font-medium text-slate-900">{{ $command->collected_at?->format('d/m/Y H:i:s') ?? 'Not collected' }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-base font-semibold text-slate-900 mb-4">Pickup Token</h3>

                @if ($command->pickupValidation)
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-slate-500">Token UUID</p>
                            <p class="font-mono break-all text-slate-900">{{ $command->pickupValidation->token_uuid }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500">OTP</p>
                            <p class="text-xl font-bold tracking-[0.2em] text-slate-900">{{ $command->pickupValidation->otp_code }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500">Status</p>
                            <p class="text-slate-900">{{ strtoupper($command->pickupValidation->status) }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500">Expires At</p>
                            <p class="text-slate-900">{{ $command->pickupValidation->expires_at?->format('d/m/Y H:i:s') ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500">Attempts</p>
                            <p class="text-slate-900">{{ $command->pickupValidation->attempts }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500">QR Payload</p>
                            <p class="font-mono text-xs break-all text-slate-700">{{ $command->pickupValidation->meta['qr_payload'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-slate-500">No pickup token issued yet.</p>
                @endif

                @if ($command->status?->value() === \App\States\Command\Confirmed::$name)
                    <form method="POST" action="{{ route('admin.pickups.issue', $command) }}" class="mt-6">
                        @csrf
                        <input type="hidden" name="regenerate" value="{{ $command->pickupValidation ? '1' : '0' }}">
                        <x-admin.button type="submit">
                            {{ $command->pickupValidation ? 'Regenerate Token' : 'Issue Token' }}
                        </x-admin.button>
                    </form>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-base font-semibold text-slate-900 mb-4">Validate Pickup</h3>

                <form method="POST" action="{{ route('admin.pickups.validate', $command) }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="token_uuid" class="block text-sm font-medium text-slate-700 mb-1">Token UUID (optional)</label>
                        <input id="token_uuid" name="token_uuid" type="text" value="{{ old('token_uuid', $command->pickupValidation?->token_uuid) }}"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="UUID from client QR/token">
                    </div>

                    <div>
                        <label for="otp" class="block text-sm font-medium text-slate-700 mb-1">OTP</label>
                        <input id="otp" name="otp" type="text" value="{{ old('otp') }}" maxlength="{{ (int) config('pickup.otp_digits', 6) }}"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter pickup OTP" required>
                    </div>

                    <x-admin.button type="submit">Validate Pickup</x-admin.button>
                </form>

                @if ($command->pickupValidation?->validatedBy)
                    <div class="mt-5 text-sm text-slate-600">
                        Validated by: <span class="font-medium text-slate-900">{{ $command->pickupValidation->validatedBy?->full_name }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

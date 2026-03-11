@extends('layouts.admin')

@section('title', 'Create User')
@section('page-title', 'Create User Account')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <div>
            <x-admin.button href="{{ route('admin.users.index') }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Users
            </x-admin.button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header flex items-center gap-3">
                <div class="w-10 h-10 rounded bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <div>
                    <h2 class="text-lg font-medium text-slate-900">New User Account</h2>
                    <p class="text-sm text-slate-500 mt-0.5">Invite a new member and configure their system role.</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('admin.users.store') }}" class="p-6 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-admin.form-input label="Full Name" name="name" required placeholder="John Doe" />
                    <x-admin.form-input label="Email Address" type="email" name="email" required placeholder="john@example.com" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-admin.form-input label="Password" type="password" name="password" required />
                    <x-admin.form-input label="Confirm Password" type="password" name="password_confirmation" required />
                </div>

                <div>
                    <label for="role" class="block text-sm font-semibold text-slate-700 mb-1.5">System Role</label>
                    <select name="role" id="role" required class="w-full px-4 py-2 bg-slate-50/50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all duration-200">
                        @foreach($roles as $value => $label)
                            <option value="{{ $value }}" {{ old('role', \App\Enums\Roles\RolesEnums::CLIENT->value) === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <x-admin.textarea label="Biography / Notes (Optional)" name="bio" rows="3" placeholder="Brief description..." />

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.users.index') }}" variant="outline">Cancel</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Create User</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

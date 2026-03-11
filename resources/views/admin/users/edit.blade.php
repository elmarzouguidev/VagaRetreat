@extends('layouts.admin')

@section('title', 'Edit User: ' . $user->name)
@section('page-title', 'Edit User Account')

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
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <h2 class="text-lg font-medium text-slate-900">{{ $user->name }}</h2>
                    <p class="text-sm text-slate-500 mt-0.5">Modify access levels or update details.</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-admin.form-input label="Full Name" name="name" :value="$user->name" required />
                    <x-admin.form-input label="Email Address" type="email" name="email" :value="$user->email" required />
                </div>

                <div class="p-4 rounded border border-slate-200 bg-slate-50 space-y-4">
                    <h3 class="text-sm font-semibold text-slate-700">Change Password (Optional)</h3>
                    <p class="text-xs text-slate-500 mb-2">Leave password fields blank if you do not wish to change it.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-admin.form-input label="New Password" type="password" name="password" />
                        <x-admin.form-input label="Confirm New Password" type="password" name="password_confirmation" />
                    </div>
                </div>

                <div>
                    <label for="role" class="block text-sm font-semibold text-slate-700 mb-1.5">System Role</label>
                    <select name="role" id="role" required class="w-full px-4 py-2 bg-slate-50/50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all duration-200 <?= auth()->id() === $user->id ? 'opacity-60 cursor-not-allowed' : '' ?>">
                        @foreach($roles as $value => $label)
                            <option value="{{ $value }}" {{ old('role', $userRole) === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if(auth()->id() === $user->id)
                        <p class="mt-2 text-xs text-slate-500">You cannot change your own role to prevent lockout.</p>
                    @endif
                </div>

                <x-admin.textarea label="Biography / Notes" name="bio" rows="3" :value="$user->bio" />

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.users.index') }}" variant="outline">Cancel</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Update User</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection

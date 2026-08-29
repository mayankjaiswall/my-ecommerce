@extends('layouts.admin')

@section('page-title', 'My Profile')
@section('page-subtitle', 'Manage your account details and password')

@section('content')

    <div class="admin-profile-header">
        <span class="admin-avatar">{{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}</span>
        <div>
            <div class="admin-profile-header__name">{{ $user->name }}</div>
            <div class="admin-profile-header__role">{{ $user->email }}</div>
        </div>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="admin-alert admin-alert--success">Your profile has been updated.</div>
    @elseif (session('status') === 'password-updated')
        <div class="admin-alert admin-alert--success">Your password has been changed.</div>
    @endif

    @if ($errors->any())
        <div class="admin-alert admin-alert--danger">{{ $errors->first() }}</div>
    @endif

    <div class="admin-profile-grid">
        <div class="admin-panel">
            <div class="admin-panel__header">
                <div>
                    <h3 class="admin-panel__title">Profile Information</h3>
                    <p class="admin-panel__subtitle">Update your name and email address</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.profile.update') }}" class="admin-form">
                @csrf
                @method('PUT')

                <div class="admin-form-row">
                    <label for="name" class="admin-form-label">Full Name</label>
                    <input type="text" id="name" name="name" class="admin-form-input @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}" required autocomplete="name">
                    @error('name')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="admin-form-row">
                    <label for="email" class="admin-form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="admin-form-input @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}" required autocomplete="email">
                    @error('email')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="admin-form-actions">
                    <button type="submit" class="admin-btn admin-btn--primary">Save Changes</button>
                </div>
            </form>
        </div>

        <div class="admin-panel">
            <div class="admin-panel__header">
                <div>
                    <h3 class="admin-panel__title">Update Password</h3>
                    <p class="admin-panel__subtitle">Choose a new password for your account</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.profile.password') }}" class="admin-form">
                @csrf
                @method('PUT')

                <div class="admin-form-row">
                    <label for="current_password" class="admin-form-label">Current Password</label>
                    <input type="password" id="current_password" name="current_password"
                        class="admin-form-input @error('current_password') is-invalid @enderror"
                        required autocomplete="current-password">
                    @error('current_password')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="admin-form-row">
                    <label for="password" class="admin-form-label">New Password</label>
                    <input type="password" id="password" name="password"
                        class="admin-form-input @error('password') is-invalid @enderror"
                        required autocomplete="new-password">
                    <span class="admin-form-hint">Must be at least 8 characters.</span>
                    @error('password')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="admin-form-row">
                    <label for="password_confirmation" class="admin-form-label">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="admin-form-input" required autocomplete="new-password">
                </div>

                <div class="admin-form-actions">
                    <button type="submit" class="admin-btn admin-btn--primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>

@endsection

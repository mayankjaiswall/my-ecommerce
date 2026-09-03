@extends('layouts.admin')

@section('page-title', 'Edit User')
@section('page-subtitle', 'Update account details for ' . $user->name)

@section('content')

    @if ($errors->any())
        <div class="admin-alert admin-alert--danger">{{ $errors->first() }}</div>
    @endif

    <div class="admin-profile-header">
        <span class="admin-avatar admin-avatar--xl">
            @if ($user->avatar_url)
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
            @else
                {{ strtoupper(substr($user->name, 0, 1)) }}
            @endif
        </span>
        <div>
            <div class="admin-profile-header__name">{{ $user->name }}</div>
            <div class="admin-profile-header__role">
                @if ($user->is_active)
                    <span class="admin-badge admin-badge--active">Active</span>
                @else
                    <span class="admin-badge admin-badge--inactive">Inactive</span>
                @endif
            </div>
        </div>
    </div>

    <div class="admin-panel admin-panel--narrow">
        <div class="admin-panel__header">
            <div>
                <h3 class="admin-panel__title">Account Details</h3>
                <p class="admin-panel__subtitle">Edit name, email, and assigned role</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="admin-form">
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

            <div class="admin-form-row">
                <label for="role_id" class="admin-form-label">Role</label>
                <select id="role_id" name="role_id" class="admin-form-input @error('role_id') is-invalid @enderror">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ (string) old('role_id', $user->role_id) === (string) $role->id ? 'selected' : '' }}>
                            {{ \Illuminate\Support\Str::title(str_replace('_', ' ', $role->name)) }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="admin-form-actions admin-form-actions--split">
                <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn--outline">Cancel</a>
                <button type="submit" class="admin-btn admin-btn--primary">Save Changes</button>
            </div>
        </form>
    </div>

    <div class="admin-panel admin-panel--narrow" style="margin-top: 20px;">
        <div class="admin-panel__header">
            <div>
                <h3 class="admin-panel__title">Account Status</h3>
                <p class="admin-panel__subtitle">Control access and account lifecycle</p>
            </div>
        </div>

        @if ($user->id !== auth()->id())
            <div class="admin-status-actions">
                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="admin-btn admin-btn--outline">
                        {{ $user->is_active ? 'Deactivate Account' : 'Activate Account' }}
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                    onsubmit="return confirm('Delete {{ $user->name }}? This cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="admin-btn admin-btn--danger">Delete Account</button>
                </form>
            </div>
        @else
            <p class="admin-form-hint">You cannot deactivate or delete your own account.</p>
        @endif
    </div>

@endsection

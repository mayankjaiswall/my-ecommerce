@extends('layouts.admin')

@section('page-title', 'Users')
@section('page-subtitle', 'View, edit, and manage all registered accounts')

@section('content')

    @if (session('status') === 'user-updated')
        <div class="admin-alert admin-alert--success">User details have been updated.</div>
    @elseif (session('status') === 'user-activated')
        <div class="admin-alert admin-alert--success">User account has been activated.</div>
    @elseif (session('status') === 'user-deactivated')
        <div class="admin-alert admin-alert--success">User account has been deactivated.</div>
    @elseif (session('status') === 'user-deleted')
        <div class="admin-alert admin-alert--success">User account has been deleted.</div>
    @endif

    @if (session('error'))
        <div class="admin-alert admin-alert--danger">{{ session('error') }}</div>
    @endif

    <div class="admin-toolbar">
        <form method="GET" action="{{ route('admin.users.index') }}">
            <input type="text" name="search" class="admin-search-input" placeholder="Search by name or email"
                value="{{ $filters['search'] ?? '' }}">

            <select name="role" class="admin-filter-select" onchange="this.form.submit()">
                <option value="">All Roles</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ (string) ($filters['role'] ?? '') === (string) $role->id ? 'selected' : '' }}>
                        {{ \Illuminate\Support\Str::title(str_replace('_', ' ', $role->name)) }}
                    </option>
                @endforeach
            </select>

            <select name="status" class="admin-filter-select" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>

            <button type="submit" class="admin-btn admin-btn--outline admin-btn--sm">Filter</button>

            @if (($filters['search'] ?? '') || ($filters['role'] ?? '') || ($filters['status'] ?? ''))
                <a href="{{ route('admin.users.index') }}" class="admin-table-action">Clear</a>
            @endif
        </form>
    </div>

    <div class="admin-table-wrap">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            <div class="admin-table-user">
                                <span class="admin-avatar">
                                    @if ($user->avatar_url)
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                                    @else
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    @endif
                                </span>
                                <div>
                                    <div class="admin-table-user__name">{{ $user->name }}</div>
                                    <div class="admin-table-user__email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if ($user->isAdmin())
                                <span class="admin-badge admin-badge--admin">Admin</span>
                            @else
                                <span class="admin-badge admin-badge--user">
                                    {{ $user->role ? \Illuminate\Support\Str::title(str_replace('_', ' ', $user->role->name)) : 'Customer' }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if ($user->is_active)
                                <span class="admin-badge admin-badge--active">Active</span>
                            @else
                                <span class="admin-badge admin-badge--inactive">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="admin-table-actions">
                                <a href="{{ route('admin.users.edit', $user) }}" class="admin-table-btn">Edit</a>

                                @if ($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="admin-table-action-form">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="admin-table-btn">
                                            {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="admin-table-action-form"
                                        onsubmit="return confirm('Delete {{ $user->name }}? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-table-btn admin-table-btn--danger">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links('vendor.pagination.admin') }}

@endsection

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
        <select id="usersRoleFilter" class="admin-filter-select">
            <option value="">All Roles</option>
            @foreach ($roles as $role)
                <option value="{{ $role->name }}">{{ \Illuminate\Support\Str::title(str_replace('_', ' ', $role->name)) }}</option>
            @endforeach
        </select>

        <select id="usersStatusFilter" class="admin-filter-select">
            <option value="">All Statuses</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>

        <button type="button" id="usersClearFilters" class="admin-table-action">Clear</button>
    </div>

    <div class="admin-table-wrap">
        <table id="usersTable" class="admin-datatable" style="width: 100%;">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th class="admin-dt-no-sort">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr data-role="{{ $user->role->name ?? '' }}" data-status="{{ $user->is_active ? 'active' : 'inactive' }}">
                        <td data-order="{{ $user->name }}">
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
                        <td data-order="{{ $user->isAdmin() ? 'admin' : ($user->role->name ?? '') }}">
                            @if ($user->isAdmin())
                                <span class="admin-badge admin-badge--admin">Admin</span>
                            @else
                                <span class="admin-badge admin-badge--user">
                                    {{ $user->role ? \Illuminate\Support\Str::title(str_replace('_', ' ', $user->role->name)) : 'Customer' }}
                                </span>
                            @endif
                        </td>
                        <td data-order="{{ $user->is_active ? 1 : 0 }}">
                            @if ($user->is_active)
                                <span class="admin-badge admin-badge--active">Active</span>
                            @else
                                <span class="admin-badge admin-badge--inactive">Inactive</span>
                            @endif
                        </td>
                        <td data-order="{{ $user->created_at->timestamp }}">{{ $user->created_at->format('M d, Y') }}</td>
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
                @endforeach
            </tbody>
        </table>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-datatable.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net@2.1.8/js/dataTables.min.js"></script>
    <script>
        (function () {
            var table = new DataTable('#usersTable', {
                order: [[3, 'desc']],
                pageLength: 10,
                dom: '<"admin-dt-controls"lf>rt<"admin-dt-footer"ip>',
                columnDefs: [
                    { targets: -1, orderable: false, searchable: false },
                ],
                language: {
                    search: '',
                    searchPlaceholder: 'Search by name or email',
                    lengthMenu: 'Show _MENU_ users',
                    emptyTable: 'No users found.',
                    zeroRecords: 'No matching users found.',
                    info: 'Showing _START_ to _END_ of _TOTAL_ users',
                    infoEmpty: 'Showing 0 users',
                    infoFiltered: '(filtered from _MAX_ total)',
                    paginate: { previous: '‹', next: '›' },
                },
            });

            DataTable.ext.search.push(function (settings, searchData, index, rowData, counter) {
                if (settings.nTable.id !== 'usersTable') {
                    return true;
                }

                var row = table.row(index).node();
                var role = document.getElementById('usersRoleFilter').value;
                var status = document.getElementById('usersStatusFilter').value;

                if (role && row.getAttribute('data-role') !== role) {
                    return false;
                }

                if (status && row.getAttribute('data-status') !== status) {
                    return false;
                }

                return true;
            });

            document.getElementById('usersRoleFilter').addEventListener('change', function () {
                table.draw();
            });

            document.getElementById('usersStatusFilter').addEventListener('change', function () {
                table.draw();
            });

            document.getElementById('usersClearFilters').addEventListener('click', function () {
                document.getElementById('usersRoleFilter').value = '';
                document.getElementById('usersStatusFilter').value = '';

                var searchInput = document.querySelector('#usersTable_wrapper .dt-search input');
                if (searchInput) {
                    searchInput.value = '';
                }

                table.search('').draw();
            });
        })();
    </script>
@endpush

@extends('layouts.admin')

@section('page-title', 'Categories')
@section('page-subtitle', 'Organize the storefront catalog into categories')

@section('content')

    @if (session('status') === 'category-created')
        <div class="admin-alert admin-alert--success">Category has been created.</div>
    @elseif (session('status') === 'category-updated')
        <div class="admin-alert admin-alert--success">Category details have been updated.</div>
    @elseif (session('status') === 'category-activated')
        <div class="admin-alert admin-alert--success">Category has been activated.</div>
    @elseif (session('status') === 'category-deactivated')
        <div class="admin-alert admin-alert--success">Category has been deactivated.</div>
    @elseif (session('status') === 'category-deleted')
        <div class="admin-alert admin-alert--success">Category has been deleted.</div>
    @endif

    <div class="admin-toolbar admin-toolbar--split">
        <div class="admin-toolbar__filters">
            <select id="categoriesStatusFilter" class="admin-filter-select">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>

            <button type="button" id="categoriesClearFilters" class="admin-table-action">Clear</button>
        </div>

        <a href="{{ route('admin.categories.create') }}" class="admin-btn admin-btn--primary admin-btn--sm">
            + Add Category
        </a>
    </div>

    <div class="admin-table-wrap">
        <table id="categoriesTable" class="admin-datatable" style="width: 100%;">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th class="admin-dt-no-sort">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr data-status="{{ $category->is_active ? 'active' : 'inactive' }}">
                        <td data-order="{{ $category->category_name }}">
                            <div class="admin-table-category__name">{{ $category->category_name }}</div>
                            <div class="admin-table-category__slug">/{{ $category->slug }}</div>
                        </td>
                        <td data-order="{{ $category->is_active ? 1 : 0 }}">
                            @if ($category->is_active)
                                <span class="admin-badge admin-badge--active">Active</span>
                            @else
                                <span class="admin-badge admin-badge--inactive">Inactive</span>
                            @endif
                        </td>
                        <td data-order="{{ $category->created_at->timestamp }}">{{ $category->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="admin-table-actions">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="admin-table-btn">Edit</a>

                                <form method="POST" action="{{ route('admin.categories.toggle-status', $category) }}" class="admin-table-action-form">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="admin-table-btn">
                                        {{ $category->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="admin-table-action-form"
                                    onsubmit="return confirm('Delete {{ $category->category_name }}? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-table-btn admin-table-btn--danger">Delete</button>
                                </form>
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
            var table = new DataTable('#categoriesTable', {
                order: [[2, 'desc']],
                pageLength: 10,
                dom: '<"admin-dt-controls"lf>rt<"admin-dt-footer"ip>',
                columnDefs: [
                    { targets: -1, orderable: false, searchable: false },
                ],
                language: {
                    search: '',
                    searchPlaceholder: 'Search by category or slug',
                    lengthMenu: 'Show _MENU_ categories',
                    emptyTable: 'No categories found.',
                    zeroRecords: 'No matching categories found.',
                    info: 'Showing _START_ to _END_ of _TOTAL_ categories',
                    infoEmpty: 'Showing 0 categories',
                    infoFiltered: '(filtered from _MAX_ total)',
                    paginate: { previous: '‹', next: '›' },
                },
            });

            DataTable.ext.search.push(function (settings, searchData, index) {
                if (settings.nTable.id !== 'categoriesTable') {
                    return true;
                }

                var row = table.row(index).node();
                var status = document.getElementById('categoriesStatusFilter').value;

                if (status && row.getAttribute('data-status') !== status) {
                    return false;
                }

                return true;
            });

            document.getElementById('categoriesStatusFilter').addEventListener('change', function () {
                table.draw();
            });

            document.getElementById('categoriesClearFilters').addEventListener('click', function () {
                document.getElementById('categoriesStatusFilter').value = '';

                var searchInput = document.querySelector('#categoriesTable_wrapper .dt-search input');
                if (searchInput) {
                    searchInput.value = '';
                }

                table.search('').draw();
            });
        })();
    </script>
@endpush

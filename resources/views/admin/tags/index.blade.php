@extends('layouts.admin')

@section('page-title', 'Tags')
@section('page-subtitle', 'Manage the attribute filters shown under each category on the shop page')

@section('content')

    @if (session('status') === 'tag-created')
        <div class="admin-alert admin-alert--success">Tag has been created.</div>
    @elseif (session('status') === 'tag-updated')
        <div class="admin-alert admin-alert--success">Tag details have been updated.</div>
    @elseif (session('status') === 'tag-activated')
        <div class="admin-alert admin-alert--success">Tag has been activated.</div>
    @elseif (session('status') === 'tag-deactivated')
        <div class="admin-alert admin-alert--success">Tag has been deactivated.</div>
    @elseif (session('status') === 'tag-deleted')
        <div class="admin-alert admin-alert--success">Tag has been deleted.</div>
    @endif

    <div class="admin-toolbar admin-toolbar--split">
        <div class="admin-toolbar__filters">
            <select id="tagsCategoryFilter" class="admin-filter-select">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>

            <select id="tagsStatusFilter" class="admin-filter-select">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>

            <button type="button" id="tagsClearFilters" class="admin-table-action">Clear</button>
        </div>

        <a href="{{ route('admin.tags.create') }}" class="admin-btn admin-btn--primary admin-btn--sm">
            + Add Tag
        </a>
    </div>

    <div class="admin-table-wrap">
        <table id="tagsTable" class="admin-datatable" style="width: 100%;">
            <thead>
                <tr>
                    <th>Tag</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th class="admin-dt-no-sort">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tags as $tag)
                    <tr data-status="{{ $tag->is_active ? 'active' : 'inactive' }}" data-category="{{ $tag->category_id }}">
                        <td data-order="{{ $tag->name }}">
                            <div class="admin-table-category__name">{{ $tag->name }}</div>
                            <div class="admin-table-category__slug">/{{ $tag->slug }}</div>
                        </td>
                        <td data-order="{{ $tag->category->category_name ?? '' }}">
                            {{ $tag->category->category_name ?? '—' }}
                        </td>
                        <td data-order="{{ $tag->is_active ? 1 : 0 }}">
                            @if ($tag->is_active)
                                <span class="admin-badge admin-badge--active">Active</span>
                            @else
                                <span class="admin-badge admin-badge--inactive">Inactive</span>
                            @endif
                        </td>
                        <td data-order="{{ $tag->created_at->timestamp }}">{{ $tag->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="admin-table-actions">
                                <a href="{{ route('admin.tags.edit', $tag) }}" class="admin-table-btn">Edit</a>

                                <form method="POST" action="{{ route('admin.tags.toggle-status', $tag) }}" class="admin-table-action-form">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="admin-table-btn">
                                        {{ $tag->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}" class="admin-table-action-form"
                                    onsubmit="return confirm('Delete {{ $tag->name }}? This cannot be undone.');">
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
            var table = new DataTable('#tagsTable', {
                order: [[3, 'desc']],
                pageLength: 10,
                dom: '<"admin-dt-controls"lf>rt<"admin-dt-footer"ip>',
                columnDefs: [
                    { targets: -1, orderable: false, searchable: false },
                ],
                language: {
                    search: '',
                    searchPlaceholder: 'Search by tag or slug',
                    lengthMenu: 'Show _MENU_ tags',
                    emptyTable: 'No tags found.',
                    zeroRecords: 'No matching tags found.',
                    info: 'Showing _START_ to _END_ of _TOTAL_ tags',
                    infoEmpty: 'Showing 0 tags',
                    infoFiltered: '(filtered from _MAX_ total)',
                    paginate: { previous: '‹', next: '›' },
                },
            });

            DataTable.ext.search.push(function (settings, searchData, index) {
                if (settings.nTable.id !== 'tagsTable') {
                    return true;
                }

                var row = table.row(index).node();
                var status = document.getElementById('tagsStatusFilter').value;
                var category = document.getElementById('tagsCategoryFilter').value;

                if (status && row.getAttribute('data-status') !== status) {
                    return false;
                }

                if (category && row.getAttribute('data-category') !== category) {
                    return false;
                }

                return true;
            });

            document.getElementById('tagsStatusFilter').addEventListener('change', function () {
                table.draw();
            });

            document.getElementById('tagsCategoryFilter').addEventListener('change', function () {
                table.draw();
            });

            document.getElementById('tagsClearFilters').addEventListener('click', function () {
                document.getElementById('tagsStatusFilter').value = '';
                document.getElementById('tagsCategoryFilter').value = '';

                var searchInput = document.querySelector('#tagsTable_wrapper .dt-search input');
                if (searchInput) {
                    searchInput.value = '';
                }

                table.search('').draw();
            });
        })();
    </script>
@endpush

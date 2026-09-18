@extends('layouts.admin')

@section('page-title', 'Products')
@section('page-subtitle', 'Manage your catalog, pricing, and stock levels')

@section('content')

    @if (session('status') === 'product-created')
        <div class="admin-alert admin-alert--success">Product has been created.</div>
    @elseif (session('status') === 'product-updated')
        <div class="admin-alert admin-alert--success">Product details have been updated.</div>
    @elseif (session('status') === 'product-activated')
        <div class="admin-alert admin-alert--success">Product has been activated.</div>
    @elseif (session('status') === 'product-deactivated')
        <div class="admin-alert admin-alert--success">Product has been deactivated.</div>
    @elseif (session('status') === 'product-deleted')
        <div class="admin-alert admin-alert--success">Product has been deleted.</div>
    @endif

    @php
        $inStockCount = $products->where('stock_status', 'in_stock')->count();
        $lowStockCount = $products->where('stock_status', 'low_stock')->count();
        $outOfStockCount = $products->where('stock_status', 'out_of_stock')->count();
    @endphp

    <div class="admin-stats-grid">
        <div class="admin-stat-card">
            <div class="admin-stat-card__top">
                <span class="admin-stat-card__icon" style="background: #1f1f1f;">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 6.25 10 2.5l7.5 3.75-7.5 3.75-7.5-3.75Z" stroke="#fff" stroke-width="1.5" stroke-linejoin="round"/>
                        <path d="M2.5 6.25V13.75L10 17.5l7.5-3.75V6.25M10 10v7.5" stroke="#fff" stroke-width="1.5" stroke-linejoin="round"/>
                    </svg>
                </span>
            </div>
            <div class="admin-stat-card__value">{{ number_format($products->count()) }}</div>
            <div class="admin-stat-card__label">Total Products</div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-card__top">
                <span class="admin-stat-card__icon" style="background: #4d7c22;">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.333 10.417 8.333 15l8.334-10" stroke="#fff" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </div>
            <div class="admin-stat-card__value">{{ number_format($inStockCount) }}</div>
            <div class="admin-stat-card__label">In Stock</div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-card__top">
                <span class="admin-stat-card__icon" style="background: #b5670a;">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 7.5v3.333M10 13.75h.008M8.626 3.144 1.68 15.417a1.25 1.25 0 0 0 1.083 1.875h14.474a1.25 1.25 0 0 0 1.083-1.875L11.374 3.144a1.25 1.25 0 0 0-2.166 0Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </div>
            <div class="admin-stat-card__value">{{ number_format($lowStockCount) }}</div>
            <div class="admin-stat-card__label">Low Stock</div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-card__top">
                <span class="admin-stat-card__icon" style="background: #c32929;">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 5 5 15M5 5l10 10" stroke="#fff" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </div>
            <div class="admin-stat-card__value">{{ number_format($outOfStockCount) }}</div>
            <div class="admin-stat-card__label">Out of Stock</div>
        </div>
    </div>

    <div class="admin-toolbar admin-toolbar--split">
        <div class="admin-toolbar__filters">
            <select id="productsCategoryFilter" class="admin-filter-select">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>

            <select id="productsStockFilter" class="admin-filter-select">
                <option value="">All Stock Levels</option>
                <option value="in_stock">In Stock</option>
                <option value="low_stock">Low Stock</option>
                <option value="out_of_stock">Out of Stock</option>
            </select>

            <select id="productsStatusFilter" class="admin-filter-select">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>

            <button type="button" id="productsClearFilters" class="admin-table-action">Clear</button>
        </div>

        <a href="{{ route('admin.products.create') }}" class="admin-btn admin-btn--primary admin-btn--sm">
            + Add Product
        </a>
    </div>

    <div class="admin-table-wrap">
        <table id="productsTable" class="admin-datatable" style="width: 100%;">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th class="admin-dt-no-sort">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr data-status="{{ $product->is_active ? 'active' : 'inactive' }}"
                        data-category="{{ $product->category_id }}"
                        data-stock="{{ $product->stock_status }}">
                        <td data-order="{{ $product->name }}">
                            <div class="admin-table-product">
                                <span class="admin-avatar admin-avatar--square">
                                    @if ($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                    @else
                                        {{ strtoupper(substr($product->name, 0, 1)) }}
                                    @endif
                                </span>
                                <div>
                                    <div class="admin-table-product__name">{{ $product->name }}</div>
                                    <div class="admin-table-product__sku">SKU: {{ $product->sku }}</div>
                                </div>
                            </div>
                        </td>
                        <td data-order="{{ $product->category->category_name ?? '' }}">
                            {{ $product->category->category_name ?? '—' }}
                        </td>
                        <td data-order="{{ $product->price }}">
                            @if ($product->compare_price)
                                <span class="admin-price-old">${{ number_format($product->compare_price, 2) }}</span>
                            @endif
                            ${{ number_format($product->price, 2) }}
                        </td>
                        <td data-order="{{ $product->stock_quantity }}">
                            {{ $product->stock_quantity }} units
                        </td>
                        <td data-order="{{ $product->is_active ? 1 : 0 }}">
                            <div style="display: flex; flex-direction: column; gap: 4px; align-items: flex-start;">
                                @if ($product->is_active)
                                    <span class="admin-badge admin-badge--active">Active</span>
                                @else
                                    <span class="admin-badge admin-badge--inactive">Inactive</span>
                                @endif

                                @if ($product->stock_status === 'out_of_stock')
                                    <span class="admin-badge admin-badge--danger">Out of Stock</span>
                                @elseif ($product->stock_status === 'low_stock')
                                    <span class="admin-badge admin-badge--warning">Low Stock</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="admin-table-actions">
                                <a href="{{ route('admin.products.edit', $product) }}" class="admin-table-btn">Edit</a>

                                <form method="POST" action="{{ route('admin.products.toggle-status', $product) }}" class="admin-table-action-form">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="admin-table-btn">
                                        {{ $product->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="admin-table-action-form"
                                    onsubmit="return confirm('Delete {{ $product->name }}? This cannot be undone.');">
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
            var table = new DataTable('#productsTable', {
                order: [[0, 'asc']],
                pageLength: 10,
                dom: '<"admin-dt-controls"lf>rt<"admin-dt-footer"ip>',
                columnDefs: [
                    { targets: -1, orderable: false, searchable: false },
                ],
                language: {
                    search: '',
                    searchPlaceholder: 'Search by product or SKU',
                    lengthMenu: 'Show _MENU_ products',
                    emptyTable: 'No products found.',
                    zeroRecords: 'No matching products found.',
                    info: 'Showing _START_ to _END_ of _TOTAL_ products',
                    infoEmpty: 'Showing 0 products',
                    infoFiltered: '(filtered from _MAX_ total)',
                    paginate: { previous: '‹', next: '›' },
                },
            });

            DataTable.ext.search.push(function (settings, searchData, index) {
                if (settings.nTable.id !== 'productsTable') {
                    return true;
                }

                var row = table.row(index).node();
                var status = document.getElementById('productsStatusFilter').value;
                var category = document.getElementById('productsCategoryFilter').value;
                var stock = document.getElementById('productsStockFilter').value;

                if (status && row.getAttribute('data-status') !== status) {
                    return false;
                }

                if (category && row.getAttribute('data-category') !== category) {
                    return false;
                }

                if (stock && row.getAttribute('data-stock') !== stock) {
                    return false;
                }

                return true;
            });

            ['productsStatusFilter', 'productsCategoryFilter', 'productsStockFilter'].forEach(function (id) {
                document.getElementById(id).addEventListener('change', function () {
                    table.draw();
                });
            });

            document.getElementById('productsClearFilters').addEventListener('click', function () {
                document.getElementById('productsStatusFilter').value = '';
                document.getElementById('productsCategoryFilter').value = '';
                document.getElementById('productsStockFilter').value = '';

                var searchInput = document.querySelector('#productsTable_wrapper .dt-search input');
                if (searchInput) {
                    searchInput.value = '';
                }

                table.search('').draw();
            });
        })();
    </script>
@endpush
